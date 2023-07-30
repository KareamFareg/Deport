<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCates extends Model
{
    const FILE_FOLDER = 'products';
    const PAGE = 'products';

    protected $table = 'shopCates';
    protected $fillable = [
         'title',
    ];
    protected $hidden = [
        'updated_at','created_at'
    ];


}
