<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferDetails extends Model
{
    const FILE_FOLDER = 'offers';
    const PAGE = 'offer';

    protected $table = 'offer_details';
    protected $fillable = [
        'images', 'title', 'logo', 'description',"offer_id",'lat','lng'
    ];
    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'title' => 'array',
        'images' => 'array',
        'description' => 'array',
    ];

    public function title($trans)
    {
        return $this->title[$trans] ?? ' : غير مترجم ';
    }

    public function description($trans)
    {
        return $this->description[$trans] ?? ' : غير مترجم ';
    }
}
