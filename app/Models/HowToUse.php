<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HowToUse extends Model
{
    const FILE_FOLDER = 'how_to_use';
    const PAGE = 'how_to_use';

    protected $table = 'how_to_use';
    protected $fillable = [
        'image', 'title', 'description','type'
    ];
    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'title' => 'array',
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
