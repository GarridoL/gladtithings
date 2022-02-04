<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharePost extends Model
{
    protected $table = 'share_posts';
    protected $fillable = ['account_id', 'comment_id', 'text'];
}
