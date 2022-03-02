<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Increment\Finance\Models\Ledger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends APIController
{

    function __construct(){
      $this->model = new Event();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $con = $data['condition'];
      $result = $this->retrieveDB($data);
      if(sizeof($result) > 0) {
        $i = 0;
        foreach($result as $key) {
          $key['image'] = app('Increment\Common\Payload\Http\PayloadController')->retrievePayloads('payload', 'event_id', 'payload_value', $key['id']);
          $key['donations'] = Ledger::where('details', '=', $key['id'])->where('description', '=', 'Event Donation')->sum('amount');
          $i++;
        }
      }
      if(sizeof($con) == 2) {
        $size = Event::where($con[0]['column'], $con[0]['clause'], $con[0]['value'])->where($con[1]['column'], $con[1]['clause'], $con[1]['value'])->where('deleted_at', '=', null)-get();
        $this->response['size'] = sizeof($size);
      }
      $this->response['data'] = $result;
      return $this->response();
    }

    public function create(Request $request) {
      $data = $request->all();
      $this->insertDB($data);
      return $this->response();
    }

    public function retrieveRandom(Request $request){
      $data = $request->all();
      $result = Event::where('account_id', '!=', $data['account_id'])->inRandomOrder()->first();
      if($result !== null) {
        $result['image'] = app('Increment\Common\Payload\Http\PayloadController')->retrievePayloads('payload', 'event_id', 'payload_value', $result['id']);
        $result['donations'] = Ledger::where('details', '=', $result['id'])->where('description', '=', 'Event Donation')->sum('amount');
      }
      $this->response['data'] = $result;
      return $this->response();
    }
}
