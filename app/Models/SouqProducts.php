<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SouqProducts extends Model
{
    const FILE_FOLDER = 'products';
    const PAGE = 'products';

    protected $table = 'SouqProducts';
    protected $fillable = [
        'image', 'title','shop_id','price','offer_id','describe','category'
    ];
    protected $hidden = [
        'updated_at','created_at'
    ];


}
