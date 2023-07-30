<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Privileg extends Model
{

  protected $table='privileges';
  public $timestamps = false;
  protected $fillable = [
        'id','title'
    ];

    protected $casts = [
      'route_parameters' => 'array',
    ];


    public function scopeForAll($query,$value)
    {
        return $query->where('for_all',$value);
    }

    public function scopeActive($query,$value)
    {
        return $query->where('is_active',$value);
    }

}
