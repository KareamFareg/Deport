<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table='user_type';
    protected $fillable = [
        'title','type_for','alias','sort',
    ];
    public $timestamps = false;

    public function scopeAdmin($query)
    {
        return $query->where('id', 1);
    }

    public function scopeUser($query)
    {
        return $query->where('id', 2);
    }


}
