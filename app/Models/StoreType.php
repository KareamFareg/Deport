<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
       protected $casts = [
         'name'=>'array',
        ];
}
