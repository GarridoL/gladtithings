<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;

class SubscriptionController extends APIController
{
    public function __construct(){
        $this->model = new Subscription();
    }

    public function create(Request $request){
        $data = $request->all();
        $data['code'] = $this->generateCode();
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
}
