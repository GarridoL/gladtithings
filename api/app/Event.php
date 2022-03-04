<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends APIModel
{
    protected $table = 'events';
    protected $fillable = ['code', 'account_id', 'name', 'description', 'type', 'category', 'location', 'start_date', 'end_date', 'time_zone', 'created_at', 'updated_at', 'deleted_at'];
}
