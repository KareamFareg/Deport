<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notifications';
    protected $fillable = [
        'user_sender_id','user_reciever_id','table_name','table_id','type','data','read_at','link','params','title','order_status','created_at'
    ];
    
    protected $casts = [
        'params' => 'array',
    ];
    public function user_sender()
    {
        return $this->belongsTo('App\User','user_sender_id') ;
    }

    public function user_reciever()
    {
        return $this->belongsTo('App\User','user_reciever_id') ;
    }


    public function item_type()
    {
        return $this->belongsTo('App\Models\ItemType','type') ;
    }

    public function scopeUnread($query)
    {
        return $query->wherenull('read_at');
    }

}
