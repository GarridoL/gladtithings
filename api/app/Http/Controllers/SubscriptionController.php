<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use Carbon\Carbon;

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
}
