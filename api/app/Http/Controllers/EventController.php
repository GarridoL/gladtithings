<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
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
      $result = Event::where($con[0]['column'], $con[0]['clause'], $con[0]['value'])->limit($data['limit'])
      ->offset($data['offset'])->orderBy(array_keys($data['sort'])[0], array_values($data['sort'])[0])->get();
      if(sizeof($result) > 0) {
        $i = 0;
        foreach($result as $key) {
          $key['image'] = app('Increment\Common\Payload\Http\PayloadController')->retrievePayloads('payload', 'event_id', 'payload_value', $key['id']);
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
