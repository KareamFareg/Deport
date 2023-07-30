<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BadWords extends Model
{
    protected $table='bad_words';
    protected $fillable = [
        'words','language_id'
    ];
    public $timestamps = false;

    const FILE_FOLDER = '';
    const FILES_TABLE_NAME = '';
    const PAGE = 'bad_words';

    protected $casts = [
      'words' => 'array',
    ];


}
