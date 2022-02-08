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
      $this->response['data'] = $result;
      return $this->response();
    }

    public function create(Request $request) {
      $data = $request->all();
      $this->insertDB($data);
      return $this->response();
    }
}
