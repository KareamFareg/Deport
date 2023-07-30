<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table='item_types';
    protected $fillable = [
        'title'
    ];

    // const FILE_FOLDER = 'car_brands';
    // const FILES_TABLE_NAME = 'car_brands';
    // const PAGE = 'car_brand';



}
