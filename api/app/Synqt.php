<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Synqt extends APIModel
{
    protected $table = 'synqts';
    protected $fillable = ['code', 'account_id', 'title', 'location_id', 'date', 'details', 'status'];
}
