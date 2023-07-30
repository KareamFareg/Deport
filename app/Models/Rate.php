<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class rate extends Model
{
    protected $table='rates';
    protected $fillable = [
   'user_id','order_id','rate','comment'
    ];



}
