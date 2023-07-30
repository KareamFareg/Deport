<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $table='mails';
    protected $fillable = [
        'name','phone','msg_type_id','description','subject','email'
    ];

}
