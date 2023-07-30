<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CategoryInfo extends Model
{
    protected $table='category_info';
    protected $fillable = [
        'category_id','language','title','alias','description','meta_description','meta_keywords','template_id','icon','image','ip',
    ];

    public function imagePath()
    {
        return asset('storage/app/'.$this->image);
    }
    public function category(){
        return $this->belongsto('App\Models\Category','category_id');
    }
}
