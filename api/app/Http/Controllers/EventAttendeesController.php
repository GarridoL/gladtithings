<?php

namespace App\Http\Controllers;

use App\EventAttendee;
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
}
