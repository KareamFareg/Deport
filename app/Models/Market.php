<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Market extends Authenticatable
{
//    use HasApiTokens;
    // use HasFactory;
    // use Notifiable;
    // use HasApiTokens;
//    use TwoFactorAuthenticatable;
const FILE_FOLDER = 'markets';
    const PAGE = 'markets';
    public $table = "markets";
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'city',
        'icon',
        
    ];

    public function shops()
    {
        return $this->hasMany('App\Models\Shop', 'souq_id') ?? null;
    }
    //############################  RELATIONS  ##################


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];



}
