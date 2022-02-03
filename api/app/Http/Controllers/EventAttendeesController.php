<?php

namespace App\Http\Controllers;

use App\EventAttendee;
use App\Event;
use Increment\Finance\Models\Ledger;
use Illuminate\Http\Request;

class EventAttendeesController extends APIController
{
    function __construct(){
      $this->model = new EventAttendee();
    }

    public function create(Request $request) {
      $data = $request->all();
      $result = EventAttendee::where('account_id', '=', $data['account_id'])->where('event_id', '=', $data['event_id'])->get();
      if(sizeof($result) > 0) {
        $this->response['data'] = null;
        $this->response['error'] = 'You have already attended to this event.';
      } else {
        $this->insertDB($data);
      }
      return $this->response();
    }

    public function retrieve(Request $request) {
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $i = 0;
      if(sizeof($result) > 0) {
        foreach($result as $key) {
          $result[$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
        }
      }
      $this->response['data'] = $result;
      return $this->response();
    }

    public function retrieveById($id){
      $result = Event::where('id', '=', $id)->get();
      if(sizeof($result) > 0) {
        $i = 0;
        foreach($result as $key) {
          $key['image'] = app('Increment\Common\Payload\Http\PayloadController')->retrievePayloads('payload', 'event_id', 'payload_value', $key['id']);
          $key['donations'] = Ledger::where('details', '=', $key['id'])->where('description', '=', 'Event Donation')->sum('amount');
          $i++;
        }
      }
      return sizeof($result) > 0 ? $result[0] : null;
    }

    public function retrieveEventsAttended(Request $request) {
      $data = $request->all();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $i = 0;
      if(sizeof($result) > 0) {
        foreach($result as $key) {
          $result[$i]['event'] = $this->retrieveById($result[$i]['event_id']);
        }
      }
      $this->response['data'] = $result;
      return $this->response();
    }
}
