<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    const FILE_FOLDER = 'offers';
    const PAGE = 'offers';

    protected $table = 'offers';
    protected $fillable = [
        'images', 'title','logo'
    ];
    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'title' => 'array',
        'images' => 'array',
    ];

    public function title($trans)
    {
        return $this->title[$trans] ?? ' : غير مترجم ';
    }

}
