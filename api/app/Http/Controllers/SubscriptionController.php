<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends APIController
{
    public function __construct(){
        $this->model = new Subscription();
        $this->notRequired = array(
            'end_date'
        );
    }

    public function create(Request $request){
        $data = $request->all();
        $data['code'] = $this->generateCode();
        $data['start_date'] = Carbon::now();
        $this->insertDB($data);
        return $this->response();
    }

    
    public function generateCode(){
        $code = 'subs_'.substr(str_shuffle($this->codeSource), 0, 59);
        $codeExist = Subscription::where('code', '=', $code)->get();
        if(sizeof($codeExist) > 0){
        $this->generateCode();
        }else{
        return $code;
        }
    }
    
    public function retrieveByParams(Request $request){
        $data = $request->all();
        $limit = isset($data['limit']) ? $data['limit'] : null;
        $condition = array(
            array('subscriptions.account_id', '=', $data['account_id']),
            array('subscriptions.deleted_at', '=', null)
        );
        if(isset($data['merchant'])){
            array_push($condition, array('subscriptions.merchant', '=', $data['merchant']));
        }
        $res = Subscription::where($condition)->limit($limit)->get();
        if(sizeof($res) > 0){
            for ($i=0; $i <= sizeof($res)-1; $i++) { 
                $item = $res[$i];
                $res[$i]['next_month'] = Carbon::createFromFormat('Y-m-d H:i:s', $item['start_date'])->addMonthsNoOverflow(1)->format('F d, Y H:i:s');
                $res[$i]['merchant_details'] =  app('Increment\Account\Merchant\Http\MerchantController')->getByParams('id', $item['merchant']);
                // $res[$i]['subsc'] = app('Increment\Account\Http\AccountController')->getByParamsWithColumns($item['account_id'], ['username', 'email']);
            }
            $this->response['data'] = $res;
        }
        return $this->response();
    }

    public function retrieveSubscriptionByMerchant(Request $request){
        $data = $request->all();
        $con = $data['condition'];
        $whereArray = array(
            array('subscriptions.merchant', '=', $data['merchant'])
        );
        if($con[0]['column'] == 'name'){
            array_push($whereArray, array(function($query){
                $query->where('first_name', $con[0]['clause'], $con[0]['value'])
                    ->orWhere('last_name', $con[0]['clause'], $con[0]['value']);
            }));
        }else{
            array_push($whereArray, array($con[0]['column'], $con[0]['clause'], $con[0]['value']));
        }
        $result = Subscription::leftJoin('accounts as T1', 'T1.id', '=', 'subscriptions.account_id')
            ->leftJoin('account_informations as T2', 'T2.account_id', '=', 'T1.id')
            ->where($whereArray)
            ->limit($data['limit'])
            ->offset($data['offset'])
            ->groupBy('subscriptions.account_id')
            ->orderBy($con[0]['column'] == 'name' ? 'T2.'.array_keys($data['sort'])[0] : array_keys($data['sort'])[0], array_values($data['sort'])[0])
            ->get(['T1.username', 'T1.email', 'T2.address', 'T2.first_name', 'T2.last_name', DB::raw('SUM(subscriptions.amount) as total_amount')]);
        
        $this->response['data'] = $result;
        return $this->response();
    }

    public function retrieveSubscribersGraph(Request $request){
        $data = $request->all();
        $currDate = Carbon::now();
        $fTransaction = Subscription::where('merchant', '=', $data['merchant_id'])->first();
        $resDates = [];
        $resData = [];
        $dates = [];
        if($data['date'] === 'yearly'){
            if($fTransaction !== null &&  $fTransaction['created_at'] !== null){
                $fTransaction['created_at'] = $fTransaction['created_at']->toDateTimeString();
                $tempYearly = CarbonPeriod::create($fTransaction['created_at'], $currDate->toDateTimeString());
                foreach ($tempYearly as $year) {
                  array_push($dates, $year->toDateString());
                }
              }
        }else if($data['date'] === 'current_year'){
            $dates = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        }else if($data['date'] === 'custom'){
            $startDate = new Carbon($data['date1']);
            $endDate = new  Carbon($data['date2']);
            $days = CarbonPeriod::create($startDate->toDateTimeString(), $endDate->toDateTimeString());
            foreach ($days as $key) {
                if($key !== null){
                    array_push($dates, $key->toDateString());
                }
            }
        }else{
            $month = $data['date'] === 'last_month' ? $currDate->subDays(30)->month : $currDate->month;
            $carbon = new Carbon(new Carbon(date('Y-m-d', strtotime('now', strtotime($currDate->year.'-' . $month . '-01'))), $this->response['timezone']));
            $i=0;
            while (intval($carbon->month) == intval($month)){
                $dates[$carbon->weekOfMonth][$i] = $carbon->toDateString();
                $carbon->addDay();
                $i++;
            }
        }
        if($data['date'] === 'yearly'){
            $temp = Subscription::select(DB::raw('sum(amount) as `amount`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                ->where('merchant', '=', $data['merchant_id'])
                ->groupby('year')
                ->get();
            if(sizeof($temp) > 0){
                for ($i=0; $i <= sizeof($temp)-1 ; $i++) { 
                $item = $temp[$i];
                array_push($resDates, $item['year']);
                array_push($resData, $item['amount']);
                }
            }
        }else if($data['date'] === 'current_year'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])
                ->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->sum('amount');
                array_push($resDates, $key);
                array_push($resData, $temp);
            }
        }else if($data['date'] === 'last_month'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                array_push($resDates, array_search($key, $dates));
                array_push($resData, $temp);
            }
        }else if($data['date'] === 'current_month'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                array_push($resDates, array_search($key, $dates));
                array_push($resData, $temp);
            }
        }else if($data['date'] === 'custom'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant'])->where('created_at', 'like', '%'.$key.'%')->sum('amount');
                array_push($resDates, $key);
                array_push($resData, $temp);
            }
        }
        $this->response['data'] = array(
          'dates' => $resDates,
          'result' => $resData
        );
        return $this->response();
      }
}
