<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fazaa extends Model
{
    const FILE_FOLDER = 'fazaa';
    const PAGE = 'faza';

    protected $table = 'fazaa';
    protected $fillable = [
         'lat',
         'lng',
         'user_id',
         "note"
    ];
    protected $hidden = [
        'updated_at','created_at'
    ];


}
