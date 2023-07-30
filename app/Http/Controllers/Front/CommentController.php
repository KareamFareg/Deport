<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Services\CommentService;
use App\Services\CommonService;
use App\Services\NotificationService;
use App\Services\ItemService;
use App\Models\Item;
use Validator;
use Illuminate\Validation\Rule;
use App\Helpers\UtilHelper;

use Auth;

class CommentController extends Controller
{
  private $commentServ;
  private $commonServ;
  private $notificationServ;
  private $itemServ;

  public function __construct(
    CommentService $commentService ,
    CommonService $commonService ,
    NotificationService $notificationService,
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

        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:200',
            'parent_id' => 'required|numeric|min:0',
            'main_parent_id' => 'required|numeric|min:0',
            'table_name' => ['required','string','max:30',Rule::in(['items']) ],
            'table_id' => 'required|integer',
        ]);


        $error = '';
        if ($validator->fails())
        {
          // $errors = $validator->errors()->toArray();
          $errors = $validator->messages()->getMessages();
          foreach ($errors as $message)
          { $error = $error . $message[0]; }

          if ($request->ajax())
          { return response()->json(array('status'=>'validation','msg'=> view('components.alert' ,['msg'=> $error ,'msgType'=>'danger'])->render() )); }
          return redirect()->back();
        }

        $comment = $this->commentServ->Store(array_merge(
            $request->all() , [
              'user_id' => Auth::id(),
              'ip' => UtilHelper::getUserIp(),
              'access_user_id' => Auth::id()
            ]
          )
        );


        if ($request->parent_id != 0){
          $this->commentServ->incementChildsCount($request->parent_id);
        }


        $this->commonServ->incrementItemComments($request->table_id);


        if ( ! $this->itemServ->checkItemBelongsToUser($request->table_id,Auth::id()) ) {
          $this->notificationServ->notifyComment(
              ['fcm','web','db'] ,
              ['user_sender_id' => Auth::id() , 'item_id' => $request->table_id , 'parent_id' => $request->parent_id ]
          );
        }



        if ($request->ajax())
        { return response()->json(array('status'=>'success','html'=>view('components.front.comments.comment-row' ,['comment'=>$comment ])->render() )); }
        return redirect()->back();


  }

  public function getCommentChilds(Request $request)
  {
      // if we want tree then filter bu parent_id
      // $childs = Comment::with('user.client.client_info')->where('parent_id',$request->id)->paginate(5);

      // if we want parent and only one level filter by main_parent_id
      $childs = Comment::with('user.client.client_info')->where('main_parent_id',$request->id)->paginate(10);

      if ($request->ajax())
      { return response()->json(array('status'=>'success','html'=>view('components.front.comments.comments' ,['comments'=>$childs->all() ])->render() )); }
      return redirect()->back();

  }

  public function index()
  {

    // $data = $this->itemServ->itemInfo([
    //   'paginate'=> 4,
    // ])->all();
    // // dd($data);
    //
    // $comments = \App\Models\Comment::where('table_id' , 1)->get();
    // // dd($comments);
    // return view('front.index', compact('data','comments'));

  }


}
