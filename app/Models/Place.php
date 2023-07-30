<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'fav_places';
    protected $fillable = [
        'user_id', 'lng', 'lat', 'name','note',
    ];
    protected $hidden = [
        'updated_at',
    ];
}
