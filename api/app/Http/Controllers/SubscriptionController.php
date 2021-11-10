<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Carbon\Carbon;
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
}
