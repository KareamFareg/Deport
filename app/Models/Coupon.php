<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'title', 'coupon', 'expire_date', 'amount','limit'
    ];

}
