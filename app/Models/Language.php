<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table='languages';
    protected $fillable = [
        'title','alias','locale','dir','image','is_active','is_default', 'user_id','ip',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active',1);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default',1);
    }

}
