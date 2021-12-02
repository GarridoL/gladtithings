<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecentlyVisitedChurchesController extends APIController
{
  public function retrieve(Request $request) {
    $data = $request->all();
    $result = $this->retrieveDB($data);
    if(sizeof($result) > 0) {
      foreach($result as $key) {
        $key['merchant'] = pp('Increment\Account\Merchant\Http\MerchantController')->getByParams('id', $key['merchant_id']);
      }
    } else {
      $this->response['data'] = [];
    }
    $this->response['data'] = $result;
  }
}
