<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends APIModel
{
    protected $table = 'reports';
    protected $fillable = ['account_id', 'payload', 'payload_value'];
}
