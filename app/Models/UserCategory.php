<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    protected $table='user_category';
    protected $fillable = [
        'user_id','category_id',
    ];
    public $timestamps = false;



}
