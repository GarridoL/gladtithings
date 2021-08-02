<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopChoice extends APIModel
{
    //
    protected $table = 'top_choices';
    protected $fillable = ['account_id', 'synqt_id', 'payload', 'payload_value'];
}
