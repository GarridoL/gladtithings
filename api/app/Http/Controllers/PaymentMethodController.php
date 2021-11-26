<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;
use App\StripeWebhooks as Stripe;

class PaymentMethodController extends APIController
{
    protected $pk;
    protected $sk;
    protected $stripe = null;
    protected $customer = null;


    public function __construct(){
        $this->model = new PaymentMethod();

        $this->pk = env('STRIPE_PK');
        $this->sk = env('STRIPE_SK');

        $this->stripe = new Stripe($this->pk, $this->sk);
    }

    public function CreateMethod(Request $request){
        $data = $request->all();

        if($this->stripe == null){
            $this->response['data'] = null;
            $this->response['error'] = 'Invalid Stripe Credentials';
            return $this->response();
        }
        $this->customer = $this->stripe->createCustomer($data['email'], $data['source']['id'], $data['name']);
        if($this->customer){
            $params = array(
                'code' => $this->generateCode(),
                'account_id'  => $data['account_id'],
                'account_code' => $data['code'],
                'payload'      => $data['method'],
                'payload_value'     => json_encode(array(
                'customer' => $this->customer,
                'source'   => $data['source']
                )),
                'status'      => 'active'
            );
            $result = $this->insertDB($params);
            $this->response['data'] = $result;
        }
        $this->response['data'] = [];
        return $this->response();
    }

    public function generateCode(){
        $code = 'pay_'.substr(str_shuffle($this->codeSource), 0, 59);
        $codeExist = PaymentMethod::where('code', '=', $code)->get();
        if(sizeof($codeExist) > 0){
            $this->generateCode();
        }else{
            return $code;
        }
    }

    public function RetrieveMethods(Request $request){
        $data = $request->all();

        $result = PaymentMethod::where('account_id', '=', $data['account_id'])->where('deleted_at', '=', null)->get();
        if(sizeof($result) > 0){
            for ($i=0; $i <= sizeof($result)-1; $i++) { 
                $item = $result[$i];
                $result[$i] = json_encode($item['payload_value']);
            }
        }
        $this->response['data'] = $result;
        return $this->response();
    }
}
