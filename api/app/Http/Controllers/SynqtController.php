<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Synqt;
use Illuminate\Support\Facades\DB;

class SynqtController extends APIController
{
  public $locationClass = 'Increment\Imarket\Location\Http\LocationController';

  function __construct()
  {
    $this->model = new Synqt();
    $this->notRequired = array('title');
  }

  public function create(Request $request)
  {
    $data = $request->all();
    $data['code'] = $this->generateCode();
    $this->model = new Synqt();
    $this->insertDB($data);
    return $this->response();
  }

  public function generateCode()
  {
    $code = 'SY_' . substr(str_shuffle($this->codeSource), 0, 61);
    $codeExist = Synqt::where('code', '=', $code)->get();
    if (sizeof($codeExist) > 0) {
      $this->generateCode();
    } else {
      return $code;
    }
  }

  public function retrieveByParams($column, $value)
  {
    $result = Synqt::where($column, '=', $value)->where('deleted_at', '=', null)->get();
    $result[0]['date_at_human'] = Carbon::createFromFormat('Y-m-d', $result[0]['date'])->copy()->tz($this->response['timezone'])->format('F j, Y');
    return sizeof($result) > 0 ? $result : [];
  }

  public function Search(Request $request)
  {
    $data = $request->all();
    $synqt = Synqt::where('id', '=', $data['synqt_id'])->where('deleted_at', '=', null)->get();
    $result = array();
    if (sizeof($synqt) > 0) {
      $condition = json_decode($synqt[0]['details'], true);
      $locations = app($this->locationClass)->getAllLocation();
      $i = 0;
      foreach ($locations as $key) {
        $distance = app($this->locationClass)->getLocationDistance('account_id', $synqt[0]['account_id'], $key['account_id']);
        $totalDistance = preg_replace('/[^0-9.]+/', '', $distance);
        if ($totalDistance < $condition['radius']) {
          $result = DB::table('products as T1')
            ->leftJoin('pricings as T2', 'T1.id', '=', 'T2.product_id')
            ->where('T2.price', '>=', $condition['price_range']['min'])
            ->where('T2.price', '<=', $condition['price_range']['max'])
            ->where('T2.account_id', '=', $key['account_id'])
            ->get();
          $result = json_decode(json_encode($result), true);
          $j=0;
          foreach ($result as $value) {
            $result[$i]['location'] = $key;
            $result[$i]['distance'] = $distance;
            $j++;
          }
            
        }
        $i++;
      }
    }
  }

  public function retrieveSynqtByParams($column, $value){
    $result = Synqt::where($column, '=', $value)->select('id', 'date', 'location_id')->where('deleted_at', '=', null)->get();
    $result[0]['date_at_human'] = Carbon::createFromFormat('Y-m-d', $result[0]['date'])->copy()->tz($this->response['timezone'])->format('F j, Y');
    return sizeof($result) > 0 ? $result : [];
  }
}
