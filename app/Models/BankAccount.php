<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_name', 'bank_name', 'account_number','national_account_number',
    ];

}
