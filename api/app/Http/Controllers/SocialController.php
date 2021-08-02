<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Increment\Account\Models\Account;

class SocialController extends APIController
{
    public function getSocialAuthenticatedUser(Request $request)
    {
        $data = $request->all();
        if ($request->has('token')) {
            $user = Account::where('token', '=', $data['token'])->get();
            if (sizeof($user) > 0) {
                $account = app('App\Http\Controllers\APIController')->retrieveAccountDetailsOnRequests($user[0]['id']);
                $merchant = app('Increment\Imarket\Merchant\Http\MerchantController')->getByParams('account_id', $user[0]['id']);
                $user[0]['profile'] = $account ? $account['profile'] : null;
                $user[0]['information'] = $account ? $account['information'] : null;
                $user[0]['merchant'] = $merchant ? $merchant : null;
            }
            $this->response['data'] = $user;
        }
        return $this->response();
    }
}
