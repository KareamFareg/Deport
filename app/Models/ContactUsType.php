<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactUsType extends Model
{
    protected $table='contact_us_types';
    protected $fillable = [
        'title',
    ];


}
