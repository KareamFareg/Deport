<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table='countries';
    protected $fillable = [
        'title','parent_id','is_active',
    ];


    public $timestamps = false;

    const FILE_FOLDER = 'countries';
    const FILES_TABLE_NAME = 'countries';
    const PAGE = 'country';

    protected $casts = [
        'title' => 'array',
      ];


    public function translation($trans)
    {
        return $this->title[$trans] ?? ' : غير مترجم ';
    }


    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }




}
