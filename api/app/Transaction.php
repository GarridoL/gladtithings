<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends APIModel
{
    protected $table = 'transactions';
    protected $fillable = ['code', 'account_id', 'title', 'location_id', 'date', 'details', 'status'];
}
