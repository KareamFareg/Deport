<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\FileUploadService;
use App\Models\ULike;
use App\Services\ItemService;
use App\Services\CommonService;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\NotificationService;
use App\Models\Item;
use App\Models\ItemInfo;
use App\User;
use App\Models\File;
use App\Models\AdvPeriod;
use App\Http\Resources\ItemResource;
use App\Http\Resources\CommentResource;
use App\Http\Requests\ItemRequest;
use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use App\Helpers\UtilHelper;
use DB;

class ItemController extends Controller
{

  use ApiResponse;
  use FileUpload;

  private $itemServ;
  private $commonServ;
  private $commentServ;
  private $userServ;
  private $notificationServ;
  private $fileuploadServ;

  public function __construct(
    ItemService $itemService,
    CommonService $commonService,
    CommentService $commentService,
    UserService $userService,
    NotificationService $notificationService,
    FileUploadService $fileuploadService)
  {
      $this->itemServ = $itemService;
      $this->commonServ = $commonService;
      $this->commentServ = $commentService;
      $this->userServ = $userService;
      $this->notificationServ = $notificationService;
      $this->fileuploadServ = $fileuploadService;

  }

  public function index()
  {

  }

  public function show($id,Request $request)
  {


      $data = $this->itemServ->itemSummery([
        'where' => [
            'id' => $id,
            'is_active' => 1,
        ],
        'user_id' => $request->user_id,
        'paginate'=> 0 ])->first();


        if ( ! $data ) {
          throw new ModelNotFoundException;
        }

        $item = $this->commonServ->incrementItemViews($id);

        return $this->responseSuccess([
          'data' =>  new ItemResource($data)
        ]);

  }

  public function store(ItemRequest $request)
  {

        $this->validate($request, [
           'user_id' => 'required|integer|exists:users,id',
        ]);

        $language = app()->getlocale();

        $data = $request->validated();

        $endDate = $this->itemServ->noEndDate();
        if ($data['type_id'] == 1) {
          $period = AdvPeriod::where('id' ,$data['adv_period_id'])->select('period')->first();
          $endDate = $this->itemServ->calculateAdvPeriods(UtilHelper::currentDate(),$period->period );
        }

        $storeItem = Item::forceCreate([
              'type_id' => $data['type_id'],
              'adv_period_id' => isset($data['adv_period_id']) ? $data['adv_period_id'] : $this->itemServ->getOpenedPeriod()->id,
              'links' => $data['links'],
              'end_date' => $endDate,
              'title_general' => $request['title_general'],
              'ip' => UtilHelper::getUserIp() ,
              'user_id' => $data['user_id'],
              'access_user_id' => $data['user_id']
              ]
        );



        $storeItemInfo = ItemInfo::forceCreate([
            'language' => $language ,
            'item_id' => $storeItem->id,
            'title' => $data['title'],
            'alias' => $data['alias'],
            'description' => $data['description'],
            'for_search' => $data['description'],
            'ip' => UtilHelper::getUserIp() ,
            'access_user_id' => $data['user_id'],
          ]
        );



        if ($request->img_0) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'img_0',
              'folder' => Item::FILE_FOLDER,
              'recordId' => $storeItemInfo->id,
              'prifex' => 'img_'.$request->user_id.'_',
          ]);

          if ($path === false) {
            $response = [ 'errors' => [ 'img_0' =>  trans('messages.error_upload_image') ] ];
            return $this->responseFaild($response);
          }

          $fileuploadServ = new FileUploadService();
          $fileuploadServ->store([
            'file_type_id' => 1,
            'file_name' => $path,
            'table_name' => Item::FILES_TABLE_NAME,
            'table_id' => $storeItem->id,
            'sort' => 1,
            'access_user_id' => $request->user_id,
          ]);
        }

        if ($request->img_1) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'img_1',
              'folder' => Item::FILE_FOLDER,
              'recordId' => $storeItemInfo->id,
              'prifex' => 'img_'.$request->user_id.'_',
          ]);

          if ($path === false) {
            $response = [ 'errors' => [ 'img_1' =>  trans('messages.error_upload_image') ] ];
            return $this->responseFaild($response);
          }

          $fileuploadServ = new FileUploadService();
          $fileuploadServ->store([
            'file_type_id' => 1,
            'file_name' => $path,
            'table_name' => Item::FILES_TABLE_NAME,
            'table_id' => $storeItem->id,
            'sort' => 2,
            'access_user_id' => $request->user_id,
          ]);
        }


        if ($request->img_2) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'img_2',
              'folder' => Item::FILE_FOLDER,
              'recordId' => $storeItemInfo->id,
              'prifex' => 'img_'.$request->user_id.'_',
          ]);

          if ($path === false) {
            $response = [ 'errors' => [ 'img_2' =>  trans('messages.error_upload_image') ] ];
            return $this->responseFaild($response);
          }

          $fileuploadServ = new FileUploadService();
          $fileuploadServ->store([
            'file_type_id' => 1,
            'file_name' => $path,
            'table_name' => Item::FILES_TABLE_NAME,
            'table_id' => $storeItem->id,
            'sort' => 3,
            'access_user_id' => $request->user_id,
          ]);
        }


        $response = [ 'message' => [ 'sucess' => trans('messages.added') ] ];
        return $this->responseSuccess($response);


  }

  public function edit(Request $request,$id)
  {

       $data = $this->itemServ->itemSummery([
         'where' => [
             'id' => $id,
             'is_active' => 1,
         ],
         'paginate'=> 0 ])->first();

         if ( ! $data ) {
           throw new ModelNotFoundException;
         }

         return $this->responseSuccess([
           'data' =>  new ItemResource($data)
         ]);

  }

  public function update(ItemRequest $request,$id)
  {


      $language = app()->getlocale();

      $item = Item::findOrFail($id);
      $itemInfo = ItemInfo::where('item_id',$id)->where('language',$language)->first();
      $user = User::findOrFail($item->user_id);

      $data = $request->validated();

      $updateItemInfo = $itemInfo->update([
          'title' => $data['title'],
          'alias' => $data['alias'],
          'description' => $data['description'],
          'for_search' => $data['description'],
          'ip' => UtilHelper::getUserIp() ,
          'access_user_id' => $user->id,
        ]
      );


      $endDate = $this->itemServ->noEndDate();
      if ($data['type_id'] == 1) {
        $period = AdvPeriod::where('id' ,$data['adv_period_id'])->select('period')->first();
        $endDate = $this->itemServ->calculateAdvPeriods(UtilHelper::currentDate(),$period->period );
      }

      $updateItem = $item->Update([
            'type_id' => $data['type_id'],
            'adv_period_id' => isset($data['adv_period_id']) ? $data['adv_period_id'] : $this->itemServ->getOpenedPeriod()->id,
            'links' => $data['links'],
            'end_date' => $endDate,
            'title_general' => $request->title_general,
            'ip' => UtilHelper::getUserIp() ,
            'access_user_id' => $user->id,
            ]
      );


    // if ($request->img_0 || $request->img_1 || $request->img_2) {
    //   File::where([ 'file_type_id' => 1, 'table_name' => 'items', 'table_id' => $id])->delete();
    // }



    if ($request->img_0) {
        $path = $this->storeFile($request , [
            'fileUpload' => 'img_0',
            'folder' => Item::FILE_FOLDER,
            'recordId' => $itemInfo->id,
            'prifex' => 'img_'.$user->id.'_',
        ]);

        if ($path === false) {
          $response = [ 'errors' => [ 'img_0' =>  trans('messages.error_upload_image') ] ];
          return $this->responseFaild($response);
        }

        File::where([ 'file_type_id' => 1, 'table_name' => 'items', 'table_id' => $id , 'sort' => 1])->delete();
        $fileuploadServ = new FileUploadService();
        $fileuploadServ->store([
          'file_type_id' => 1,
          'file_name' => $path,
          'table_name' => Item::FILES_TABLE_NAME,
          'table_id' => $item->id,
          'sort' => 1,
          'access_user_id' => $user->id,
        ]);
    }


    if ($request->img_1) {
        $path = $this->storeFile($request , [
            'fileUpload' => 'img_1',
            'folder' => Item::FILE_FOLDER,
            'recordId' => $itemInfo->id,
            'prifex' => 'img_'.$user->id.'_',
        ]);

        if ($path === false) {
          $response = [ 'errors' => [ 'img_1' =>  trans('messages.error_upload_image') ] ];
          return $this->responseFaild($response);
        }

        File::where([ 'file_type_id' => 1, 'table_name' => 'items', 'table_id' => $id , 'sort' => 2])->delete();
        $fileuploadServ = new FileUploadService();
        $fileuploadServ->store([
          'file_type_id' => 1,
          'file_name' => $path,
          'table_name' => Item::FILES_TABLE_NAME,
          'table_id' => $item->id,
          'sort' => 2,
          'access_user_id' => $user->id,
        ]);
    }

    if ($request->img_2) {
        $path = $this->storeFile($request , [
            'fileUpload' => 'img_2',
            'folder' => Item::FILE_FOLDER,
            'recordId' => $itemInfo->id,
            'prifex' => 'img_'.$user->id.'_',
        ]);

        if ($path === false) {
          $response = [ 'errors' => [ 'img_2' =>  trans('messages.error_upload_image') ] ];
          return $this->responseFaild($response);
        }

        File::where([ 'file_type_id' => 1, 'table_name' => 'items', 'table_id' => $id , 'sort' => 3])->delete();
        $fileuploadServ = new FileUploadService();
        $fileuploadServ->store([
          'file_type_id' => 1,
          'file_name' => $path,
          'table_name' => Item::FILES_TABLE_NAME,
          'table_id' => $item->id,
          'sort' => 3,
          'access_user_id' => $user->id,
        ]);
    }





    // success
    $response = [
      'message' => [ 'sucess' => trans('messages.updated') ] ,
    ];
    return $this->responseSuccess($response);


  }

  public function delete(Request $request,$id)
  {

      DB::transaction(function() use($id) {
        DB::table('comments')->where([ 'table_id' => $id , 'table_name' => 'items' ])->delete();
        DB::table('likes')->where([ 'table_id' => $id , 'table_name' => 'items' ])->delete();
        DB::table('files')->where([ 'table_id' => $id , 'table_name' => 'items' , 'file_type_id' => 1 ])->delete();
        DB::table('item_info')->where('item_id',$id)->delete();
        DB::table('items')->where('id',$id)->delete();
      });


      // success
      $response = [
        'message' => [ 'sucess' => trans('messages.deleted') ] ,
      ];
      return $this->responseSuccess($response);


  }

  public function storeLike(Request $request)
  {

    $this->validate($request, [
       'user_id' => 'required|integer|exists:users,id',
       'table_id' => 'required|integer|exists:items,id',
    ]);


    $validate = $this->commonServ->validateStoreLike($request->all());
    if ($validate !== true) {
        $errors = UtilHelper::prepareErrorBag($validate);
        $response = [ 'errors' => [ 'validation' => $errors] ];
        return $this->responseFaild($response,422);
    }

    $validateDoublicateLike = $this->commonServ->validateDoublicateLike( array_merge(
        $request->all() , [ 'user_id' => $request->user_id ]
      )
    );


    if ($validateDoublicateLike){
               // $response = [ 'errors' => [ 'validation' => __('like.doublicate_like') ] ];
               // return $this->responseFaild($response,422);
               $ULike = $this->commonServ->disLike( $request );
               if ($ULike) {
                   $item = $this->commonServ->decrementItemLikes($request->table_id);
               }
    } else {
              $ULike = $this->commonServ->storeLike( array_merge(
                   $request->all() , [
                     'user_id' => $request->user_id,
                     'ip' => UtilHelper::getUserIp(),
                     'access_user_id' => $request->user_id
                   ]
                 )
               );

               if ($ULike) {
                   $item = $this->commonServ->incrementItemLikes($request->table_id);

                   // notify , check if user like his product so don't notify
                   if ( ! $this->itemServ->checkItemBelongsToUser($request->table_id,$request->user_id) ) {
                     $this->notificationServ->notifyLike(
                         ['fcm','web','db'] ,
                         ['user_sender_id' => $request->user_id , 'item_id' => $request->table_id ]
                     );
                   }
               }
    }


     $sendObject = (object) ['likes' => $item->likes];

     // success
     $response = [
       'message' => [ 'sucess' => trans('messages.updated') ] ,
       'data' => $sendObject
     ];
     return $this->responseSuccess($response);


  }

  public function getComments(Request $request,$id)
  {

    $data = $this->commentServ->getCommentsRootOfItem($id);

    if ( empty($data->all()) ) {
      throw new ModelNotFoundException;
    }

    return $this->responseSuccess([
      'data' =>  CommentResource::collection($data) ,
      'paginate' => [
        'total' => $data->total() ,
        'lastPage' => $data->lastPage() ,
        'currentPage' => $data->currentPage() ,
      ]
    ] , 206 );

  }


  public function destroyFile(Request $request)
  {


      $file = File::where('id',$request->route('file_id'))->first();
      if (! $file) {
        throw new ModelNotFoundException;
      }

      $fileBelongsToUser = $this->itemServ->checkFileBelongsToUser($file->table_id , auth('api')->id());
      if (! $fileBelongsToUser) {
        $response = [ 'errors' => [ 'delete' => __('messages.error_belongs_to_user')] ];
        return $this->responseFaild($response,401);
      }


      if (! File::destroy($request->route('file_id')) ) {
        $response = [ 'errors' => [ 'delete' => __('messages.deleted_faild')] ];
        return $this->responseFaild($response,422);
      }

      $response = [
        'message' => [ 'sucess' => __('messages.deleted') ] ,
      ];
      return $this->responseSuccess($response);


  }



}
