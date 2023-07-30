<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const FILE_FOLDER = 'orders';
    const PAGE = 'order';

    protected $fillable = [
        'status', 'note', 'invoice', 'shipper_id','price','deserve_more','comment','payment_type','charge_wallet','canceld_by',
        'cancel_date','coupon','discount','accept_date','delivery_date','commission_status','shipping','commission','shop_name','package_type','user_static','shipper_static',
        'shop_id','user_id','payment_status','tawseelMessage','refrenceCode',
    ];

    protected $casts = [
        'user_static' => 'array',
        'shipper_static' => 'array',
    ];
    public function items()
    {
        //return $this->hasMany('App\Models\OrderItem', 'order_id')->where('addition_service',0) ?? null;
        return $this->hasMany('App\Models\OrderItem', 'order_id') ?? null;
    }
    public function addition_items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id')->where('addition_service',1) ?? null;
    }

    public function type_image()
    {
        return $this->hasOne('App\Models\CategoryInfo', 'category_id', 'type')->where('language', app()->getLocale())->first()->image;
    }
    public function type_title()
    {
        return optional($this->hasOne('App\Models\CategoryInfo', 'category_id', 'type')->where('language', app()->getLocale())->first())->title;
    }

    public function user_data()
    {
        return $this->hasOne('App\User', 'id', 'user_id');

    }
    public function shipper_data()
    {
        return $this->hasOne('App\User', 'id', 'shipper_id');

    }
    public function offer()
    {
        return $this->hasOne('App\Models\OrderOffer', 'order_id', 'id')->where('status', 1);

    }

    

    public function orderStatus()
    {
        switch ($this->status) {
            case 0:{return trans('order.status_0');}
            case 1:{return trans('order.status_1');}
            case 2:{return trans('order.status_2');}
            case 3:{return trans('order.status_3');}
            case 4:{return trans('order.status_4');}
            case 5:{return trans('order.status_5');}
        }
    }
    public function orderPayment()
    {
        switch ($this->payment_type) {
            case 0:{return trans('order.payment_0');}
            case 1:{return trans('order.payment_1');}
            case 2:{return trans('order.payment_2');}
            case 3:{return trans('order.payment_3');}
        }
    }

    public function category()
    {
        return $this->belongsto('App\Models\Category','type');
    }
}
