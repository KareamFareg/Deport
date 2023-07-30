<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemInfo extends Model
{
    protected $table='item_info';
    protected $fillable = [
        'item_id','language','title','alias','tags','brief','meta_description','meta_keywords','description','for_search','image','image_alt','template_id','is_active','access_user_id'
    ];

    public function imagePath()
    {
        return asset('storage/app/'.$this->image);
    }

}
