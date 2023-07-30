<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table='comments';
    protected $fillable = [
        'user_id','comment','parent_id','main_parent_id','table_name','table_id','approved','childs_count','ip','access_user_id'
    ];

    const FILE_FOLDER = 'comments';
    const FILES_TABLE_NAME = 'comments';
    const PAGE = 'comment';

    public function user()
    {
        return $this->belongsto('App\User','user_id') ;
    }

    public function item()
    {
        return $this->belongsto('App\Models\Item','table_id') ;
    }

}
