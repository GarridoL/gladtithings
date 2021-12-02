<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecentlyVisitedChurch;
use Carbon\Carbon;

class RecentlyVisitedChurchesController extends APIController
{

  function __construct(){
    $this->model = new RecentlyVisitedChurch();
  }

  public function retrieve(Request $request) {
    $data = $request->all();
    $result = $this->retrieveDB($data);
    if(sizeof($result) > 0) {
      foreach($result as $key) {
        $key['merchant'] = app('Increment\Account\Merchant\Http\MerchantController')->getByParams('id', $key['merchant_id']);
      }
    } else {
      $this->response['data'] = [];
    }
    $this->response['data'] = $result;
    return $this->response();
  }

  public function create(Request $request) {
    $data = $request->all();
    $result = $this->retrieveDB($data['parameter']);
    if(sizeof($result) > 0) {
      RecentlyVisitedChurch::where('id', '=', $result[0]['id'])->update(array(
        'created_at' => Carbon::now()
      ));
    } else {
      $this->model = new RecentlyVisitedChurch();
      $this->insertDB($data['insert']);
    }
    return $this->response();
  }
}
