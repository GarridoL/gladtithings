<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecentlyVisitedChurch extends APIModel
{
    protected $table = 'recently_visited_churches';
    protected $fillable = ['account_id', 'merchant_id'];
}
