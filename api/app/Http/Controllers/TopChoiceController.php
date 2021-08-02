<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Synqt;
use App\TopChoice;
use Illuminate\Support\Facades\DB;
use Increment\Imarket\Merchant\Models\Merchant;

class TopChoiceController extends APIController
{
  public $synqtClass = 'App\Http\Controllers\SynqtController';
  public $merchantClass = 'Increment\Imarket\Merchant\Http\MerchantController';
  public $ratingClass = 'Increment\Common\Rating\Http\RatingController';
  public $locationClass = 'Increment\Imarket\Location\Http\LocationController';

  function __construct(){
    $this->model = new TopChoice();
  }

  public function retrieve(Request $request){
    $data = $request->all();
    $con = $data['condition'];
    $result = TopChoice::where($con[0]['column'], $con[0]['clause'], $con[0]['value'])->where('deleted_at', '=', null)->select('synqt_id', 'payload_value', 'account_id')->get();
    $synqts = null;
    $result = $result->groupBy('payload_value');
    $i = 0;
    $j = 0;
    if(sizeof($result) > 0){
      foreach($result as $key => $element) {
        if($i < 5) {
          $synqts[$i]['members'] = TopChoice::where('payload_value', '=', $key)->where('synqt_id', '=', $con[0]['value'])->get();
          $synqts[$i]['synqt'] = app($this->synqtClass)->retrieveByParams('id', $con[0]['value']);
          $synqts[$i]['merchant'] = app($this->merchantClass)->getByParams('id', $key);
          $synqts[$i]['rating'] = app($this->ratingClass)->getRatingByPayload('merchant_id', $element[0]['payload_value']);
          $synqts[$i]['total_super_likes'] = $this->countByParams($con[0]['value'], $key);
          $synqts[$i]['distance'] = app($this->locationClass)->getLocationDistanceByMerchant($synqts[$i]['synqt'][0]['location_id'], json_decode($synqts[$i]['merchant']['address'] ));
          foreach($synqts[$i]['members'] as $el) {
            $el['name'] = $this->retrieveNameOnly($el->account_id);
            $el['account'] = $this->retrieveAccountDetailsProfileOnly($el->account_id);
            $j++;
          }
          $i++;
        } else {
          break;
        }
      }
    }
    $this->response['data'] = $synqts;
    return $this->response();
  }

  public function retrieveActivities(Request $request) {
    $data = $request->all();
    $con = $data['condition'];
    $result = TopChoice::where($con[0]['column'], $con[0]['clause'], $con[0]['value'])->where($con[1]['column'], $con[1]['clause'], $con[1]['value'])->where('deleted_at', '=', null)->select('synqt_id', 'payload_value', 'account_id')->offset($data['offset'])->limit($data['limit'])->get();
    $synqts = null;
    $i = 0;
    $j = 0;
    if(sizeof($result) > 0){
      foreach($result as $element) {
        $synqts[$i]['members'] = TopChoice::where('payload_value', '=', $element->payload_value)->where('synqt_id', '=', $element->synqt_id)->select('id', 'account_id')->get();
        $synqts[$i]['synqt'] = $this->retrieveSynqtByParams('id', $element->synqt_id);
        $synqts[$i]['merchant'] = $this->getMerchantByParams('id', $element->payload_value);
        $synqts[$i]['rating'] = app($this->ratingClass)->getRatingByPayload('merchant_id', $element->payload_value);
        $synqts[$i]['total_super_likes'] = $this->countByParams($element->synqt_id, $element->payload_value);
        $synqts[$i]['distance'] =  app($this->locationClass)->getLocationDistanceByMerchant($synqts[$i]['synqt'][0]['location_id'], json_decode($synqts[$i]['merchant']['address'] ));
        foreach($synqts[$i]['members'] as $el) {
            $el['name'] = $this->retrieveNameOnly($el->account_id);
            $el['account'] = $this->retrieveAccountDetailsProfileOnly($el->account_id);
            $j++;
        }
        $i++;
      }
    }
    $this->response['data'] = $synqts;
    return $this->response();
  }

  public function retrieveSynqtByParams($column, $value){
    $result = Synqt::where($column, '=', $value)->select('id', 'date')->where('deleted_at', '=', null)->get();
    $result[0]['date_at_human'] = Carbon::createFromFormat('Y-m-d', $result[0]['date'])->copy()->tz($this->response['timezone'])->format('F j, Y');
    return sizeof($result) > 0 ? $result : [];
  }


  public function countByParams($synqt, $merchant){
    $result = TopChoice::where('synqt_id', '=', $synqt)->where('payload_value', '=', $merchant)->where('status', '=', 'super-like')->count();
    return $result;
  }

  public function getMerchantByParams($column, $value) {
    $result = Merchant::where($column, '=', $value)->select('account_id', 'id', 'logo', 'address', 'name')->get();
    return sizeof($result) > 0 ? $result[0] : null;
  }
}
