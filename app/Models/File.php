<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table='files';
    protected $fillable = [
        'file_type_id','language','file_name','table_name','table_id','sort','comment','is_private','is_active','deleted','ip','access_user_id','options',
    ];

    const FILES_PATH = 'storage/app/' ;

    protected $casts = ['options' => 'array'];
    protected $appends = ['file_info'];


    public function item()
    {
        return $this->belongsTo('App\Models\Item','table_id');
    }

    public function scopeOf($query,$value)
    {
        return $query->where('table_name',$value);
    }

    public function scopeOfType($query,$value)
    {
        return $query->where('file_type_id',$value);
    }

    public function scopeOfId($query,$value)
    {
        return $query->where('table_id',$value);
    }

    public function scopeOfLanguage($query,$value)
    {
        return $query->where('language',$value);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active',1);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private',1);
    }

    public function scopeDeleted($query,$value)
    {
        return $query->where('deleted',$value);
    }

    public function getOption(string $option)
    {
        return array_get($this->options, $option);
    }

    public function getFileInfoAttribute()
    {
      return 'asd';
        // $mime = \Storage::mimeType($this->file_name);
        // $size = formatSizeUnits(\Storage::size($this->file_name));
        //
        // if (array_key_exists($mime, $this->icons)) {
        //     return array('icon' => $this->icons[$mime], 'mime' => $mime, 'size' => $size);
        // }
        //
        // return array('icon' => 'fa-file', 'mime' => $mime, 'size' => $size);
    }

    public function getFullPathAttribute()
    {
        return asset($this->file_name);
    }

    public function filePath()
    {
        return asset('storage/app/'.$this->file_name);
    }

}
