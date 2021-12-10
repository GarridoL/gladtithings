<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends APIModel
{
    protected $table = 'announcements';
    protected $fillable = ['merchant_id', 'title', 'description'];
}
