<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table='faqs';
    protected $fillable = [
        'question','answer','ip','access_user_id','is_active'
    ];

    const FILE_FOLDER = 'faqs';
    const FILES_TABLE_NAME = 'faqs';
    const PAGE = 'faq';

    protected $casts = [
      'question' => 'array',
      'answer' => 'array',
    ];

    // public function getQuestionAttribute($value,$language = null)
    // {
    //   if (! $language) { $language = app()->getLocale(); }
    //
    //   $value = json_decode($value,true);
    //   return isset($value[$language]) ? $value[$language] : null;
    // }
    //
    // public function getAnswerAttribute($value,$language = null)
    // {
    //   if (! $language) { $language = app()->getLocale(); }
    //
    //   $value = json_decode($value,true);
    //   return isset($value[$language]) ? $value[$language] : null;
    // }

}
