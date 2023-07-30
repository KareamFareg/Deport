<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='tranaction_history';
    protected $fillable = [
   'user_id','title','description','amount','date','order_code','user_name','message'
    ];

    protected $hidden = [
        'updated_at','created_at'
    ];

}
