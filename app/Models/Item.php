<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table='items';
    protected $fillable = [
        'user_id','type_id','kind_id','end_date','parent_id','title_general','price','links','adv_period_id','code','map','item_related','item_accessories','sort','likes','viewes','comments','rate','rate_count','is_commented','is_active','access_user_id'
    ];



    const FILE_FOLDER = 'items';
    const FILES_TABLE_NAME = 'items';
    const PAGE = 'item';

    protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    // protected $appends = ['IsLikedBy'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id') ;
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\Category','App\Models\ItemCategory','item_id','category_id') ;
    }

    public function translation()
    {
        $language = app()->getLocale();
        return $this->hasMany('App\Models\ItemInfo','item_id')->where('language','=',$language);
    }

    public function item_info()
    {
        return $this->hasMany('App\Models\ItemInfo','item_id');
    }

    public function item_type()
    {
        return $this->belongsto('App\Models\ItemType','type_id');
    }

    public function item_period()
    {
        return $this->belongsto('App\Models\AdvPeriod','adv_period_id');
    }

    public function comments()
    {
        return $this->hasmany('App\Models\Comment','table_id')->where('table_name','items') ;
    }

    public function likes()
    {
        return $this->hasMany('App\Models\ULike','table_id')->where('table_name','items') ;
    }

    public function liked()
    {
        // dublicated because likes relation (above) has the same name of like(count) in items table
        return $this->hasMany('App\Models\ULike','table_id')->where('table_name','items');
    }

    public function files()
    {
        return $this->hasMany('App\Models\File', 'table_id','id')->where('table_name', static::FILES_TABLE_NAME);
    }

    public function scopeInfo($query,$language=null)
    {

      if(! $language) { $language = app()->getLocale(); }

      return $query->with(['user.client.client_info','item_type','item_period','files','item_info' => function($query) use($language) {
        $query->where('language',$language);
      }]);
      // ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
    }

    public function scopeOffer($query)
    {
        return $query->where('type_id', 1);
    }

    public function scopeCoupon($query)
    {
        return $query->where('type_id', 2);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeActiveAdmin($query)
    {
        return $query->where('is_active_admin', 1);
    }

    // function getIsLikedByAttribute() {
    //   return $this->first_name . ' ' . $this->last_name;
    // }




}
