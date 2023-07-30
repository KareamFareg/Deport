<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClientInfo extends Model
{
    protected $table='client_info';
    protected $fillable = [
        'client_id','language_id','title','alias','description','logo','banner','meta_tags', 'meta_keywords','meta_description','work_times','last_viewed','viewed','is_active','user_id','ip',
    ];

    public function logoPath()
    {
        return asset('storage/app/'.$this->logo);
    }

    public function bannerPath()
    {
        return asset('storage/app/'.$this->banner);
    }

}
