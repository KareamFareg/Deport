<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table='contact_us';
    protected $fillable = [
        'title','mobile','contact_us_type_id','ip','user_id','description'
    ];

    const FILE_FOLDER = 'contact_us';
    const FILES_TABLE_NAME = 'contact_us';
    const PAGE = 'contact_us';

    public function type()
    {
      return $this->belongsto('App\Models\ContactUsType','contact_us_type_id');
    }

    public function user()
    {
      return $this->belongsto('App\User','user_id');
    }


}
