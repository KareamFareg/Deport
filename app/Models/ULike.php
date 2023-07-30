<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ULike extends Model
{
    protected $table='likes';
    protected $fillable = [
        'user_id','table_name','table_id','ip','access_user_id','is_active'
    ];


}
