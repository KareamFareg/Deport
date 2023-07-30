<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';
    protected $fillable = [
        'title_general','type','parent_id','user_type_id','sort','is_active','is_default','access_user_id','ip',
    ];
    public $timestamps = false;

    public static $categoryTypes = ['category','service'];

    const FILE_FOLDER = 'categories';
    const FILES_TABLE_NAME = 'categories';
    const PAGE = 'category';


    public function deliveryCharges()
    {
        return $this->hasMany('App\Models\DeliveryCharge','category_id') ;
    }

    public function users()
    {
        return $this->belongsToMany('App\User','App\Models\UserCategory','category_id','user_id') ;
    }

    public function translation()
    {
        $language = app()->getLocale();
        return $this->hasMany('App\Models\CategoryInfo','category_id')->where('language','=',$language);
    }

    public function category_info()
    {
        return $this->hasMany('App\Models\CategoryInfo','category_id');
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
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
