<?php

namespace App\Http\Controllers;

use App\EventAttendee;
use App\Event;
use Increment\Finance\Models\Ledger;
use Illuminate\Http\Request;
use App\Jobs\Notifications;

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
        if($this->checkLimit($data['event_id']) == true) {
          $this->insertDB($data);
          $name = $this->retrieveNameOnly($data['account_id']);
          $data['topic'] = 'attend-event';
          $data['title'] = 'New Event Attendee';
          $data['message'] = $data['username'].' attended your event '.$data['event_name'].'.';
          Notifications::dispatch('message', $data);
        } else {
          $this->response['data'] = null;
          $this->response['error'] = 'Limit reached. You can no longer attend to this event for this event is only limited to a specific number of users.';
        }
      }
      return $this->response();
    }

    public function retrieve(Request $request) {
      $data = $request->all();
      $con = $data['condition'];
      $this->retrieveDB($data);
      $result = $this->response['data'];
      $i = 0;
      if(sizeof($result) > 0) {
        foreach($result as $key) {
          $result[$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $i++;
        }
      }
      $size = EventAttendee::where($con[0]['column'], $con[0]['clause'], $con[0]['value'])->get();
      $this->response['size'] = sizeof($size);
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

    public function checkLimit($id){
      $result = Event::where('id', '=', $id)->first();
      if($result != null) {
        $limit = $result['limit'];
        $attendees = EventAttendee::where('event_id', '=', $id)->where('deleted_at', '=', null)->get();
        if(sizeof($attendees) == $limit) {
          return false;
        } else {
          return true;
        }
      }
      return true;
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
