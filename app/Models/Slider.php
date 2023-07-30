<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table='sliders';
    protected $fillable = [
        'name','position','images',
    ];

    const FILE_FOLDER = 'sliders';
    const FILES_TABLE_NAME = 'sliders';
    const PAGE = 'slider';

    protected $casts = [
      'images' => 'array',
    ];

    // public function imagePath()
    // {
    //     return asset('storage/app/'.$this->image);
    // }

}
