<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $table='client_type';
    protected $fillable = [
        'title',
    ];
    public $timestamps = false;


}
