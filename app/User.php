<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use App\Models\RoleUser;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const ADMIN_ROLE = 1;
    const SITE_ROLE = 2;

    const FILE_FOLDER = 'users';
    const FILES_TABLE_NAME = 'users';
    const PAGE = 'user';

    protected $fillable = [
        'type_id', 'parent_id', 'name', 'user_name', 'phone', 'email', 'gender', 'license', 'city', 'id_number', 'id_card','refrenceCode' ,'idNumber','identityTypeId','TawseelErrorMessage',
        'password', 'image', 'banner', 'signature', 'is_active', 'approved','mobile_type', 'fcm_token', 'userable_id', 'userable_type', 'amount','city_id','region_id','carTypeId','carNumber','vehicleSequenceNumber','dateOfBirth'
    ];

    protected $hidden = [
        'password', 'remember_token', 'fcm_token',
        //'type_id','parent_id','userable_id','userable_type','banner','signature',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        //  'lang'=>'array',
    ];

    public function rate()
    {
        $count = \App\Models\Rate::where('user_id', $this->id)->count();
        $sum = \App\Models\Rate::where('user_id', $this->id)->sum('rate');
        if ($count == 0) {
            return 0;
        } else {
            $rate = $sum / $count;
            return (int) $rate;
        }

    }
    public function rate_count()
    {
        return \App\Models\Rate::where('user_id', $this->id)->count();
    }

    public function orders_price($ordersIds, $commission_status = 0)
    {
        return \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'shipper_id' => $this->id])->sum('price');
    }
    public function shipping_price($ordersIds, $commission_status = 0)
    {
        return \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'shipper_id' => $this->id])->sum('shipping');
    }
    public function discount($ordersIds, $commission_status = 0)
    {
        return \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'shipper_id' => $this->id])->sum('discount');
    }

    public function charge_wallet($ordersIds, $commission_status = 0)
    {
        return \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'shipper_id' => $this->id])->sum('charge_wallet');
    }

    public function payment($ordersIds, $payment_type = 1, $commission_status = 0)
    {
        $price = \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'payment_type' => $payment_type, 'shipper_id' => $this->id])->sum('price');
        $shipping = \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'payment_type' => $payment_type, 'shipper_id' => $this->id])->sum('shipping');
        $commission = \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'payment_type' => $payment_type, 'shipper_id' => $this->id])->sum('commission');
        $discount = \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'payment_type' => $payment_type, 'shipper_id' => $this->id])->sum('discount');
        return $price + $shipping + $commission - $discount;
    }

    public function commission($ordersIds, $commission_status = 0)
    {
        return \App\Models\Order::whereIn('id', $ordersIds)->where(['commission_status' => $commission_status, 'shipper_id' => $this->id])->sum('commission');
    }
    public function shipper_amount($ordersIds, $commission_status = 0)
    {
        return $this->shipping_price($ordersIds, $commission_status);
    }

    public function deserved_amount($ordersIds, $commission_status = 0)
    {
        return $this->payment($ordersIds, 2, $commission_status) + $this->payment($ordersIds, 3, $commission_status) - $this->charge_wallet($ordersIds, $commission_status) - $this->commission($ordersIds, $commission_status);
    }

    public function level()
    {
        $role_id = optional(RoleUser::where('user_id', $this->id)->first())->role_id ?? null;
        if ($role_id != null) {
            return $role_level = optional(Role::where('id', $role_id)->first())->level ?? null;
        } else {
            return null;
        }
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'user_id');
    }

    public function primaryRole()
    {
        return $this->roles()->wherePivot('primary', true);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'App\Models\UserCategory', 'user_id', 'category_id');
    }

    // morph
    public function userable()
    {
        return $this->morphTo();
    }

    public function forEmployee()
    {
        return $this->userable_type == 'App\Models\Employee';
    }

    public function forDepartment()
    {
        return $this->userable_type == 'App\Models\Department';
    }

    // public function getGenderAttribute()
    // {
    //     if ( $this->forEmployee() ) {
    //       return $this->userable->gender_id ;
    //     }
    //     if ( $this->forDepartment() ) {
    //       return $this->userable->gendertype_id ;
    //     }
    // }
    // public function getGenderTitleAttribute()
    // {
    //     if ( $this->forEmployee() ) {
    //       $gender = $this->userable->gender()->first();
    //       return $gender ? $gender->title : null ;
    //     }
    //     if ( $this->forDepartment() ) {
    //       $gender = $this->userable->gendertype()->first();
    //       return $gender ? $gender->title : null ;
    //     }
    // }
    // public function getGenderAliasAttribute()
    // {
    //     if ( $this->forEmployee() ) {
    //       return ($this->userable->gender_id == 2) ? 'female' : null ;
    //     }
    //     if ( $this->forDepartment() ) {
    //       return ($this->userable->gendertype_id == 2) ? 'female' : null ;
    //     }
    // }
    // end morph

    public function imagePath()
    {
        return asset('storage/app/' . $this->image);
    }

    public function signaturePath()
    {
        return asset('storage/app/' . $this->signature);
    }

    // public function files()
    // {
    //     return $this->hasMany('App\Models\File', 'table_id')->where('table_name','users');
    //     // return $this->morphMany('App\Models\file','table_name','table_id') ;
    // }

    public function scopeInfo($query, $language = null)
    {

        if (!$language) {$language = app()->getLocale();}

        return $query->with(['client.client_info' => function ($query) use ($language) {
            $query->where('language', $language);
        }]);

    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeActiveAdmin($query)
    {
        return $query->where('is_active_admin', 1);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', 1);
    }

    // public function scopeAdmin($query)
    // {
    //     return $query->where('ROLE', self::ADMIN_ROLE);
    // }
    //
    // public function scopeClient($query)
    // {
    //     return $query->where('ROLE', self::CLIENT_ROLE);
    // }
    //
    // public function scopeUser($query)
    // {
    //     return $query->where('ROLE', self::SITE_ROLE);
    // }

    public function scopeTypeAdmin($query)
    {
        return $query->where('type_id', 1);
    }

    public function scopeTypeSupervisor($query)
    {
        return $query->where('type_id', 2);
    }

    public function scopeTypeSchoole($query)
    {
        return $query->where('type_id', 3);
    }

    public function isActive($value)
    {
        return $this->is_active == $value;
    }

    public function isActiveAdmin($value)
    {
        return $this->is_active_admin == $value;
    }

    public function isVerified($value)
    {
        return $this->is_verified == $value;
    }

    public function isAdmin(): bool
    {
        return $this->type_id == 1;
    }

    public function isSupervisor(): bool
    {
        return $this->type_id == 2;
    }

    public function isSchool(): bool
    {
        return $this->type_id == 3;
    }

}
