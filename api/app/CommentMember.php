<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentMember extends Model
{
    //
    protected $table = 'comment_members';
    protected $fillable = ['account_id', 'comment_id', 'liked', 'joined'];
}
