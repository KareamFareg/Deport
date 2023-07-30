<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\UserResource;

class OrderOffer extends Model
{
    protected $table = 'order_offers';
    protected $fillable = [
        'user_id','order_id', 'lng', 'lat', 'shipping','status',
    ];
    protected $hidden = [
        'updated_at',
    ];


    public function user_data()
    {
        return $this->hasOne('App\User', 'id', 'user_id');

    }


}
