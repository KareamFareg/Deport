<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Models\File;

class FileUploadService
{

    public function store( $params = [], $language = null)
    {
      $language = $language ?? app()->getLocale();

      return File::create($params + ['language' => $language ,'ip' => UtilHelper::getUserIp() , 'options' => [] ]);
    }

    public function destroy( $where = [] )
    {
      return File::where($where)->delete();
    }

    public function getFilesOfUserItems($user_id,$paginate)
    {

      $files = DB::Table('files')
        ->join('items','items.id','files.table_id')
        ->join('users', function($join) use($user_id){
          $join->on('users.id','items.user_id')->where('user_id',$user_id);
        })
        ->where('files.table_name','items')
        ->select('files.id','files.file_name','table_id')
        ->paginate($paginate);

        return $files;

    }

    public function validateFile()
    {
        // if (! $upload_token) {
        //     throw ValidationException::withMessages(['message' => trans('general.missing_upload_token')]);
        // }
    }

}
