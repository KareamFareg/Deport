<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Services\CommentService;
use App\Services\CommonService;
use App\Services\NotificationService;
use App\Services\ItemService;
use App\Models\Item;
use App\User;
use Validator;
use Illuminate\Validation\Rule;
use App\Helpers\UtilHelper;
use App\Traits\ApiResponse;
use App\Http\Resources\CommentResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;

class CommentController extends Controller
{
  use ApiResponse;
  private $commentServ;
  private $commonServ;
  private $notificationServ;
  private $itemServ;

  public function __construct(
    CommentService $commentService ,
    CommonService $commonService ,
    NotificationService $notificationService ,
    ItemService $itemService
  )
  {

     $this->commentServ = $commentService;
     $this->commonServ = $commonService;
     $this->notificationServ = $notificationService;
     $this->itemServ = $itemService;
      // $this->share([
      //   'page' => Comment::PAGE,
      // ]);

      $this->defaultLanguage = $this->defaultLanguage();

  }

  public function store(Request $request)
  {

        $request->merge([ 'comment' => UtilHelper::formatNormal($request->comment) ]);

        $this->validate($request, [
          'comment' => 'required|max:200',
          'parent_id' => 'required|numeric|min:0',
          'main_parent_id' => 'required|numeric|min:0',
          'table_name' => ['required','string','max:30',Rule::in(['items']) ],
          'table_id' => 'required|integer|exists:items,id',
          'user_id' => 'required|integer|exists:users,id'
        ]);



        $comment = $this->commentServ->Store(array_merge(
            $request->all() , [
              'user_id' => $request->user_id,
              'ip' => UtilHelper::getUserIp(),
              'access_user_id' => $request->user_id
            ]
          )
        );


        if ($request->parent_id != 0){
          $this->commentServ->incementChildsCount($request->parent_id);
        }


        $this->commonServ->incrementItemComments($request->table_id);


        if ( ! $this->itemServ->checkItemBelongsToUser($request->table_id,$request->user_id) ) {
          $this->notificationServ->notifyComment(
              ['fcm','web','db'] ,
              ['user_sender_id' => $request->user_id , 'item_id' => $request->table_id , 'parent_id' => $request->parent_id ]
          );
        }


        // success
        $response = [
          'message' => [ 'sucess' => trans('messages.updated') ] ,
        ];
        return $this->responseSuccess($response);


  }

  public function getCommentChilds(Request $request)
  {

      // if we want tree then filter bu parent_id
      // $data = Comment::with('user.client.client_info')->where('parent_id',$request->id)->paginate(5);

      // if we want parent and only one level filter by main_parent_id
      $data = Comment::with('user.client.client_info')->where('main_parent_id',$request->id)->paginate(5);

      // get mention user
      foreach($data as $item) {
          $item->mention_user_id = null;
          $item->mention_user_name = null;

          $parent_comment = Comment::find($item->parent_id);
          $parent_user = null;
          if ($parent_comment) {
            $parent_user = User::find($parent_comment->user_id);
          }

          if ($parent_user) {
            $item->mention_user_id = $parent_user->id;
            $item->mention_user_name = $parent_user->name;
          }
      }


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


}
