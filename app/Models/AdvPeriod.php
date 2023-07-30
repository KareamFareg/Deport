<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdvPeriod extends Model
{
    protected $table='adv_periods';
    protected $fillable = [
        'id','title','is_active','period','opened'
    ];
    public $timestamps = false;

    const FILE_FOLDER = '';
    const FILES_TABLE_NAME = '';
    const PAGE = 'adv_periods';

    public function translation()
    {
      // $language = app()->getLocale();
      // return $this->hasMany('App\Models\CarTypeInfo','car_type_id')->where('language','=',$language);
    }

    public function scopeOpened($query)
    {
        return $query->where('opened',1);
    }

    public function scopeLimited($query)
    {
        return $query->where('opened',0);
    }

}
