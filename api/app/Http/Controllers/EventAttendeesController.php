<?php

namespace App\Http\Controllers;

use App\EventAttendee;
use Illuminate\Http\Request;

class EventAttendeesController extends APIController
{
    function __construct(){
        $this->model = new EventAttendee();
    }
}
