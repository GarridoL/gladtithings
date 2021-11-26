<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends APIModel
{
    protected $table = 'payment_methods';
    protected $fillable = ['code', 'account_id', 'account_code', 'payload', 'payload_value', 'status'];
}
