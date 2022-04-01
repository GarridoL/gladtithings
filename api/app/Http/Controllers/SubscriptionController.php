<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Increment\Finance\Models\Ledger;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Jobs\Notifications;
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
        $exist = Subscription::where('account_id', '=', $data['account_id'])->where('merchant', '=', $data['merchant'])->where('deleted_at', '=', null)->get();
        if(sizeof($exist) > 0){
            $this->response['error'] = 'Subscription already existed';
            $this->response['data'] = null;
            return $this->response();
        }
        $data['code'] = $this->generateCode();
        $data['start_date'] = Carbon::now();
        $this->insertDB($data);
        $data['topic'] = 'subscription';
        $data['title'] = 'New Subscription';
        $data['message'] = 'You have new church subscriber!';
        Notifications::dispatch('message', $data);
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

        $this->response['size'] = Subscription::leftJoin('accounts as T1', 'T1.id', '=', 'subscriptions.account_id')
        ->leftJoin('account_informations as T2', 'T2.account_id', '=', 'T1.id')
        ->where($whereArray)
        ->groupBy('subscriptions.account_id')
        ->orderBy($con[0]['column'] == 'name' ? 'T2.'.array_keys($data['sort'])[0] : array_keys($data['sort'])[0], array_values($data['sort'])[0])
        ->count();
        $this->response['data'] = $result;
        return $this->response();
    }

    public function retrieveSubscribersGraph(Request $request){
        $data = $request->all();
        $currDate = Carbon::now();
        $fTransaction = Subscription::where('merchant', '=', $data['merchant_id'])->first();
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
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
        }else if($data['date'] === '7days'){
            $last7date = $currDate->subDays(7)->toDateString();
            $temp = CarbonPeriod::create($last7date, Carbon::yesterday()->toDateString());
            for ($i=0; $i <= sizeof($temp->toArray())-1; $i++) { 
                $item = $temp->toArray()[$i];
                array_push($dates, $item->toDateString());
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
                    array_push($resData, abs($item['amount']));
                }
            }
        }else if($data['date'] === 'current_year'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])
                ->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->sum('amount');
                
                $month = Carbon::createFromFormat('m/d/Y', $key.'/01/'.$currDate->year)->format('F');
                array_push($resDates, $month);
                array_push($resData, abs($temp));
            }
        }else if($data['date'] === 'last_month'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                array_push($resData, abs($temp));
            }
        }else if($data['date'] === 'current_month'){
            foreach ($dates as $key) {
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                array_push($resData, abs($temp));
            }
        }else if($data['date'] === '7days'){
            foreach($dates as $value){
                $day = Carbon::createFromFormat('Y-m-d', $value)->format('l');
                $temp = Subscription::where('merchant', '=', $data['merchant_id'])->where('created_at', 'like', '%'.$value.'%')->sum('amount');
                array_push($resDates, $day);
                array_push($resData, abs($temp));
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

    public function retrieveDashboard(Request $request){
        $data = $request->all();
        $currDate = Carbon::now();
        $last30days = Carbon::now()->subDays(30)->toDateTimeString();
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        $dates = [];
        $amount = [];
        //getting total sends for last 30 days
        $tempSends = Ledger::where('account_id', '=', $data['account_id'])
          ->where('amount', '<', 0)
          ->whereBetween('created_at', [$last30days, $currDate->toDateTimeString()])
          ->get([DB::raw('SUM(amount) as total_sends')]);
        
        //getting total received for last 30 days
        $tempReceived = Ledger::where('account_id', '=', $data['account_id'])
          ->where('amount', '>', 0)
          ->whereBetween('created_at', [$last30days, $currDate->toDateTimeString()])
          ->get([DB::raw('SUM(amount) as total_received')]);
    
    
         //initializing the where conditions
         $whereArray= array(
          array('account_id', '=', $data['account_id']),
          array('amount', '>', 0),
          array(function($query){
            $query->where('details', 'like', '%'.'"payment_payload":"direct_transfer"'.'%')
              ->orWhere('details', '=', 'subscription');
          })
        );
        
        //get the first transaction for yearly getting of data
        $fTransaction = Ledger::where($whereArray)->first();
    
        //declaring variable where dateslist and data will insert
        $resDates = [];
        $resData = [];
    
        //getting the list of dates per given date type
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
        }else if($data['date'] === '7days'){
            $last7date = $currDate->subDays(7)->toDateString();
            $temp = CarbonPeriod::create($last7date, Carbon::yesterday()->toDateString());
            for ($i=0; $i <= sizeof($temp->toArray())-1; $i++) { 
                $item = $temp->toArray()[$i];
                array_push($dates, $item->toDateString());
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
    
        //getting the data per given date type
        if($data['date'] === 'yearly'){
          $temp = Ledger::select(DB::raw('sum(amount) as `amount`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where($whereArray)
            ->groupby('year')
            ->get();
          if(sizeof($temp) > 0){
            for ($i=0; $i <= sizeof($temp)-1 ; $i++) { 
              $item = $temp[$i];
              array_push($resDates, $item['year']);
              array_push($resData, abs($item['amount']));
            }
          }
        }else if($data['date'] === 'current_year'){
          foreach ($dates as $key) {
            $temp = Ledger::where($whereArray)
              ->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->sum('amount');
            
            $month = Carbon::createFromFormat('m/d/Y', $key.'/01/'.$currDate->year)->format('F');
            array_push($resDates, $month);
            array_push($resData, abs($temp));
          }
        }else if($data['date'] === 'last_month'){
          foreach ($dates as $key) {
            $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
            $tempPosition = array_search($key, $dates);
            if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                array_push($resDates, $tempPosition."th week");
            }else{
                array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
            }
            array_push($resData, abs($temp));
        }
        }else if($data['date'] === 'current_month'){
          foreach ($dates as $key) {
            $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
            $tempPosition = array_search($key, $dates);
            if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                array_push($resDates, $tempPosition."th week");
            }else{
                array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
            }
            array_push($resData, abs($temp));
          }
        }else if($data['date'] === '7days'){
            foreach($dates as $value){
                $day = Carbon::createFromFormat('Y-m-d', $value)->format('l');
                $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$value.'%')->sum('amount');
                array_push($resDates, $day);
                array_push($resData, abs($temp));
            }
        }else if($date['custom'] === 'custom'){
          foreach ($dates as $key) {
            $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$key.'%')->sum('amount');
            array_push($resDates, $key);
            array_push($resData, abs($temp));
          }
        }
    
        $fin = array(
          'dates' => $resDates,
          'total_amount_received' => $resData,
          'sends' => sizeof($tempSends) > 0 ? $tempSends[0]['total_sends'] : 0,
          'received' => sizeof($tempReceived) > 0 ? $tempReceived[0]['total_received'] : 0,
        );
        $this->response['data'] = $fin;
        return $this->response();
    }
    public function retrieveSubscriptionsGraph(Request $request){
        $data = $request->all();
        $currDate = Carbon::now();
        
        $fTransaction = Ledger::where('description', '=', 'Subscription')->where('account_id', '=', $data['account_id'])->first();
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        $resDates = [];
        $resData = [];
        $resDetails = [];
        $whereArray= array(
            array('account_id', '=', $data['account_id']),
            array('description', '=', 'Subscription'),
            array('amount', '>', 0)
        );

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
        }else if($data['date'] === '7days'){
            $last7date = $currDate->subDays(7)->toDateString();
            $temp = CarbonPeriod::create($last7date, Carbon::yesterday()->toDateString());
            for ($i=0; $i <= sizeof($temp->toArray())-1; $i++) { 
                $item = $temp->toArray()[$i];
                array_push($dates, $item->toDateString());
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
            $temp = Ledger::select('*', DB::raw('sum(amount) as `amount`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where($whereArray)
            ->groupby('year')
            ->get();
            if(sizeof($temp) > 0){
                for ($i=0; $i <= sizeof($temp)-1 ; $i++) { 
                    $item = $temp[$i];
                    $temp[$i]['details'] = json_decode($item['details']) !== null ? json_decode($item['details']) : $item['details'];
                    if(isset($temp[$i]['details']->to)){
                        $temp[$i]['details']->to = $this->retrieveNameOnly($temp[$i]['details']->to);
                        $temp[$i]['details']->from = $this->retrieveNameOnly($temp[$i]['details']->from);
                    }
                    $account = app('Increment\Account\Http\AccountController')->retrieveAccountInfo($item['account_id']);
                    $additionals = array(
                        'account' => $account,
                        'details' => $temp
                    );
                    array_push($resDates, $item['year']);
                    array_push($resData, $item['amount']);
                    array_push($resDetails, $additionals);
                }
            }
        }else if($data['date'] === 'current_year'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->sum('amount');
                $month = Carbon::createFromFormat('m/d/Y', $key.'/01/'.$currDate->year)->format('F');
                $data =Ledger::where($whereArray)->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                    if(isset($data['details']->to)){
                        $data['details']->to = $this->retrieveNameOnly($data['details']->to);
                        $data['details']->from = $this->retrieveNameOnly($data['details']->from);
                    }
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resDates, $month);
                array_push($resData, ($temp));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === 'last_month'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                $data =Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                    if(isset($data['details']->to)){
                        $data['details']->to = $this->retrieveNameOnly($data['details']->to);
                        $data['details']->from = $this->retrieveNameOnly($data['details']->from);
                    }
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resData, ($temp));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === 'current_month'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                $data =Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                    if(isset($data['details']->to)){
                        $data['details']->to = $this->retrieveNameOnly($data['details']->to);
                        $data['details']->from = $this->retrieveNameOnly($data['details']->from);
                    }
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resData, ($temp));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === '7days'){
            foreach($dates as $value){
                $day = Carbon::createFromFormat('Y-m-d', $value)->format('l');
                $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$value.'%')->sum('amount');
                $data =Ledger::where($whereArray)->where('created_at', 'like', '%'.$value.'%')->first();
                if($data != null){
                    $data['details'] = json_decode($data['details']);
                    if(isset($data['details']->to)){
                        $data['details']->to = $this->retrieveNameOnly($data['details']->to);
                        $data['details']->from = $this->retrieveNameOnly($data['details']->from);
                    }
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resDates, $day);
                array_push($resData, $temp);
                array_push($resDetails, $additionals);
            }
        }

        $this->response['data'] = array(
            'dates' => $resDates,
            'result' => $resData,
            'details' => $resDetails,
        );
        return $this->response();
    }
    public function retrieveDonations(Request $request){
        $data = $request->all();
        $currDate = Carbon::now();
        $fTransaction = Ledger::where('description', '=', 'Event Donation')->where('details', '=', $data['account_id'])->first();
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        $resDates = [];
        $resData = [];
        $resDetails = [];
        $whereArray= array(
            array('details', '=', $data['account_id']),
            array('description', '=', 'Event Donation'),
        );

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
        }else if($data['date'] === '7days'){
            $last7date = $currDate->subDays(7)->toDateString();
            $temp = CarbonPeriod::create($last7date, Carbon::yesterday()->toDateString());
            for ($i=0; $i <= sizeof($temp->toArray())-1; $i++) { 
                $item = $temp->toArray()[$i];
                array_push($dates, $item->toDateString());
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
            $temp = Ledger::select('*', DB::raw('sum(amount) as `amount`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where($whereArray)
            ->groupby('year')
            ->get();
            if(sizeof($temp) > 0){
                for ($i=0; $i <= sizeof($temp)-1 ; $i++) { 
                    $item = $temp[$i];
                    $account = app('Increment\Account\Http\AccountController')->retrieveAccountInfo($item['account_id']);
                    $additionals = array(
                        'account' => $account,
                        'details' => $item
                    );
                    array_push($resDates, $item['year']);
                    array_push($resData, ((float)$item['amount'] * -1));
                    array_push($resDetails, $additionals);
                }
            }
        }else if($data['date'] === 'current_year'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->sum('amount');
                $month = Carbon::createFromFormat('m/d/Y', $key.'/01/'.$currDate->year)->format('F');
                $data = Ledger::where($whereArray)->where('created_at', 'like', '%'.$currDate->year.'-'.$key.'%')->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resDates, $month);
                array_push($resData, ($temp * -1));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === 'last_month'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                $data = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                array_push($resData, ($temp * -1));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === 'current_month'){
            foreach ($dates as $key) {
                $temp = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->sum('amount');
                $tempPosition = array_search($key, $dates);
                $data = Ledger::where($whereArray)->whereBetween('created_at', [$key[array_key_first($key)], end($key)])->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                if(($tempPosition%100) >= 11 &&  ($tempPosition%100) <= 13){
                    array_push($resDates, $tempPosition."th week");
                }else{
                    array_push($resDates, $tempPosition.$ends[$tempPosition%10]." week");
                }
                array_push($resData, ($temp * -1));
                array_push($resDetails, $additionals);
            }
        }else if($data['date'] === '7days'){
            foreach($dates as $value){
                $day = Carbon::createFromFormat('Y-m-d', $value)->format('l');
                $temp = Ledger::where($whereArray)->where('created_at', 'like', '%'.$value.'%')->sum('amount');
                $data = Ledger::where($whereArray)->where('created_at', 'like', '%'.$value.'%')->first();
                if($data !== null){
                    $data['details'] = json_decode($data['details']);
                }
                $account = $data !== null ? app('Increment\Account\Http\AccountController')->retrieveAccountInfo($data['account_id']) : null;
                $additionals = array(
                    'account' => $account,
                    'details' => $data
                );
                array_push($resDates, $day);
                array_push($resData, ($temp * -1));
                array_push($resDetails, $additionals);
            }
        }

        $this->response['data'] = array(
            'dates' => $resDates,
            'result' => $resData,
            'details' => $resDetails,
        );
        return $this->response();
    }
    public function dashboard(Request $request){
        $data = $request->all();
        $result = array();
        $account = app('Increment\Account\Http\AccountController')->getAccountIdByParamsWithColumns($data['account_code'], ['id', 'code']);
        if ($account == null) {
        $this->response['error'] = 'Invalid Access';
        $this->response['data'] = null;
        return $this->response();
        }
        $currencies = app('Increment\Finance\Http\LedgerController')->getAllCurrencies($data['account_id'], $data['account_code']);
        foreach ($currencies as $key) {
        $sum = app('Increment\Finance\Http\LedgerController')->getSum($account['id'], $account['code'], $key);
        $hold = app('Increment\Finance\Http\LedgerController')->getPendingAmount($account['id'], $key);
        $currency = array(
            'currency'  => $key,
            'available_balance'   => floatval($sum - $hold),
            'current_balance'     => $sum,
            'balance'             => floatval($sum - $hold),
        );
        $result[] = $currency;
        }

        $history = Ledger::select('code', 'account_code', 'amount', 'description', 'currency', 'details', 'created_at')
        ->where('account_id', '=', $account['id'])
        ->where('account_code', '=', $account['code'])
        ->offset(0)
        ->limit(3)
        ->orderBy('created_at', 'desc')
        ->get();
        $i = 0;

        foreach ($history as $key) {
        $history[$i]['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $history[$i]['created_at'])->copy()->tz($this->response['timezone'])->format('F j, Y h:i A');
        $i++;
        }

        $this->response['data'] = array(
        'ledger' => $result,
        'history' => $history
        );
        return $this->response();
    }
}
