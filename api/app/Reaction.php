<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends APIModel
{
    protected $table = 'reactions';
    protected $fillable = ['comment_id', 'reaction'];
}
