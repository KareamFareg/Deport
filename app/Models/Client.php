<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table='clients';
    protected $fillable = [
        'title_general','country_id','contacts','email','phone','parent_id','notify_mail','mobile','administrator','is_active','is_active_admin','user_id','ip',
    ];
    public $timestamps = false;

    const FILE_FOLDER = 'clients';
    const FILES_TABLE_NAME = 'clients';
    const PAGE = 'client';

    public function translation()
    {
        $language = app()->getLocale();
        return $this->hasMany('App\Models\ClientInfo','client_id')->where('language','=',$language);
    }

    public function client_info()
    {
        return $this->hasMany('App\Models\ClientInfo','client_id');
    }

    public function user()
    {
        return $this->belongsto('App\User','user_id');
    }

    public function imagePath()
    {
        return asset('storage/app/'.$this->image);
    }

    public function bannerPath()
    {
        return asset('storage/app/'.$this->image);
    }
}
