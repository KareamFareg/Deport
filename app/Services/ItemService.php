<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Helpers\CoreHelper;
use App\Models\Item;
use App\Models\ItemInfo;
use Auth;
use App\Traits\FileUpload;
use App\Services\FileUploadService;

class ItemService
{

    use FileUpload;

    public function queryAll( $where=[], $fields=[] , $sort=[], $options=[] )
    {

      $where = isset($filter['where']) ? $filter['where'] : [];
      $fields = isset($filter['fields']) ? $filter['fields'] : ['*'];
      $sort = isset($filter['sort']) ? $sort : 'id';
      $language = isset($filter['language']) ? $filter['language'] : app()->getLocale();
      $paginate = isset($filter['paginate']) ? $filter['paginate'] : 0;

      $data = Item::with(['likes','comments','files','item_info' => function($query) use($language) {
        $query->where('language',$language);
      }])
      ->where($where)->select($fields)->orderBy($sort);

      if (!$paginate) {
         return $data->get();
       } else {
         if($paginate == 0){
            return $data;  // doesn't work with first. it still return collection so make first() in controlor
         } else {
            return $data->paginate($paginate);
         }
       }



    }

    public function itemSummery( $filter = []  )
    {

        $where = isset($filter['where']) ? $filter['where'] : [];
        $user_id = isset($filter['user_id']) ? $filter['user_id'] : 0;
        $fields = isset($filter['fields']) ? $filter['fields'] : ['*'];
        $sort = isset($filter['sort']) ? $sort : 'id';
        $language = isset($filter['language']) ? $filter['language'] : app()->getLocale();
        $paginate = isset($filter['paginate']) ? $filter['paginate'] : 0;

        $data = Item::with(['user.client.client_info','item_type','item_period',
        'files' => function ($query) {
            $query->orderBy('sort');
        },
        'liked' => function ($query) use( $user_id ) { // get if user likes this item
            $query->where('user_id',$user_id);
        },
        'item_info' => function($query) use($language) {
            $query->where('language',$language);
        }])
        ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
        ->where($where)->select($fields)->orderBy('id','desc');

        if (!$paginate) {
           return $data->get();
         } else {
           return $data->paginate($paginate);
         }

    }

    public function getUserItemsLikes($user_id,$language = null)
    {

        $language = app()->getLocale();

        $data = Item::with(['user.client.client_info','item_type','files','item_info' => function($query) use($language) {
          $query->where('language',$language);
        }])->whereHas('likes' , function($query) use($user_id) {
          $query->where('user_id', $user_id);
        })->orderBy('id','desc')->paginate(5);

        return $data;
    }


    public function getUserItemsLikesOffers($user_id,$language = null)
    {

        $language = app()->getLocale();

        $data = Item::with(['user.client.client_info','item_type','files','item_info' => function($query) use($language) {
          $query->where('language',$language);
        }])->whereHas('likes' , function($query) use($user_id) {
          $query->where('user_id', $user_id);
        })->orderBy('id','desc')->where('type_id' , 1)->paginate(5);

        return $data;
    }

    public function getUserItemsLikesCoupons($user_id,$language = null)
    {

        $language = app()->getLocale();

        $data = Item::with(['user.client.client_info','item_type','files','item_info' => function($query) use($language) {
          $query->where('language',$language);
        }])->whereHas('likes' , function($query) use($user_id) {
          $query->where('user_id', $user_id);
        })->orderBy('id','desc')->where('type_id' , 2)->paginate(5);

        return $data;
    }

    public function getUserItemsComments($user_id,$language = null)
    {

        $language = app()->getLocale();

        $data = Item::with(['user.client.client_info','item_type','files','item_info' => function($query) use($language) {
          $query->where('language',$language);
        }])->whereHas('comments' , function($query) use($user_id) {
          $query->where('user_id', $user_id);
        })->paginate(2);

        return $data;

    }

    public function storeImages($image,$record_id,$table_id,$user_id,$file_type_id)
    {


        $language = app()->getLocale();

        $path = $this->storeFromBase( $image , [
            'folder' => Item::FILE_FOLDER,
            'recordId' => $record_id,
            'prifex' => 'img_'.$user_id.'_',
        ]);

        if ($path === false) {
          return false;
        }

        $fileuploadServ = new FileUploadService();
        $fileuploadServ->store([
          'file_type_id' => 1,
          'file_name' => $path,
          'table_name' => Item::FILES_TABLE_NAME,
          'table_id' => $table_id,
          'access_user_id' => $user_id,
        ]);

        return true;

    }

    public function calculateAdvPeriods($date,$period)
    {

      return UtilHelper::dateAdd($date,$period);

    }

    public function setActive( $item , $status )
    {
        $item->update([ 'is_active' => $status ]);
    }

    public function checkFileBelongsToUser($item_id , $user_id)
    {
        return Item::where( ['id' => $item_id ,'user_id' => $user_id ])->exists();
    }

    public function checkItemBelongsToUser($item_id , $user_id)
    {
        return Item::where( ['id' => $item_id ,'user_id' => $user_id ])->exists();
    }

    public function getOpenedPeriod()
    {
      return \App\Models\AdvPeriod::opened()->first();
    }

    public function noEndDate()
    {
      return  UtilHelper::DateToDb('01-12-2050');
    }



}
