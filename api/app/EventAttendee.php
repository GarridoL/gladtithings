<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventAttendee extends APIModel
{
    protected $table = 'event_attendees';
    protected $fillable = ['account_id', 'event_id'];
}
