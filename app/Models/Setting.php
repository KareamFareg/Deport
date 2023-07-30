<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'language',
        'app_title',
        'facebook',
        'tweeter',
        'snapchat',
        'instagram',
        'linkedin',
        'website',
        'phone_1',
        'UPhone',
        'CRMPhone',
        'customer_service',
        'mail',
        'address',
        'app_android_lnk',
        'app_ios_link',
        'app_share_note',
        'work_times',
        'logo',
        'register_st_1',
        'register_st_2',
        'register_st_3',
        'about_us',
        'about_us_image',
        'terms',
        'privacy',
        'lat',
        'lng',
        'addition_service_cost',
        'commission_percent',
        'minimum_shipping',
        'geofire_radius',
        'telegram',

    ];

    protected $casts = [
        // 'language'=>'array',
        'app_title' => 'array',
        // 'facebook'=>'array',
        // 'tweeter'=>'array',
        // 'instagram'=>'array',
        // 'linkedin'=>'array',
        // 'website'=>'array',
        // 'phone_1'=>'array',
        // 'mail'=>'array',
        // 'address'=>'array',
        // 'app_android_lnk'=>'array',
        // 'app_ios_link'=>'array',
        'app_share_note' => 'array',
        // 'work_times'=>'array',
        // 'logo'=>'array',
        'register_st_1' => 'array',
        'register_st_2' => 'array',
        'register_st_3' => 'array',
        'about_us' => 'array',
        // 'about_us_image'=>'array',
        'terms' => 'array',
        'privacy' => 'array',
        // 'lat'=>'array',
        // 'lng'=>'array',
    ];

    const FILE_FOLDER = 'settings';
    const FILES_TABLE_NAME = 'settings';
    const PAGE = 'setting';

    public function translation($field, $trans)
    {
        return $this->$field[$trans] ?? ' : غير مترجم ';
    }

}
