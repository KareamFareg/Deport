<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Services\CommentService;
use App\Helpers\UtilHelper;
use Auth;
use Validator;

class CommentController extends AdminController
{

    private $commentServ;

    public function __construct(CommentService $commentService)
    {

        $this->commentServ = $commentService;

        $this->share([
          'page' => Comment::PAGE,
          'recordsCount' => Comment::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $language = $this->defaultLanguage;

      $data = Comment::with(['item.translation','user'])
      ->where('table_name','items');

      // active
      if ($request->active_status === "0" || $request->active_status === "1" ) {
        $data->where('approved' , $request->active_status);
      };

      if ($request->crit){
        $data->where('comment','like','%'.$request->crit.'%')  ;
      }

      $request->flash();

      $data = $data->get();

      $data = $data->groupBy('table_id');

      return view('admin.comments.index',compact(['data']));

    }

    public function updateComment(Request $request)
    {

      $request->merge([ 'comment' => UtilHelper::formatNormal($request->comment) ]);
      $request->merge([ 'id' => $request->route('id') ]);

      $validator = Validator::make($request->all(), [
          'comment' => 'required|max:200',
          'id' => 'required|integer|exists:comments,id',
      ]);

      $error = '';
      if ($validator->fails())
      {
        $errors = $validator->messages()->getMessages();
        foreach ($errors as $message)
        { $error = $error . $message[0]; }

        if ($request->ajax())
        // array('status'=>'validation','msg'=> view('components.alert' ,['msg'=> $error ,'msgType'=>'danger'])->render() ,'alert'=>'swal')
        { return response()->json( ['status'=>'error', 'msg'=> $error, 'alert'=>'swal' ] ); }
        return redirect()->back();
      }


      $comment = Comment::find($request->id);

      $comment = $comment->Update(['comment' => $request->comment]);

      if ($comment) {
        if ($request->ajax()) {
          return response()->json( ['status'=>'success', 'msg'=> __('messages.updated'), 'alert'=>'swal' ] );
        }
        return redirect()->back();
      }


      if ($request->ajax()) {
        return response()->json( ['status'=>'error', 'msg'=> __('messages.updated_faild'), 'alert'=>'swal' ] );
      }
      return redirect()->back();


    }

    public function setActive(Request $request)
    {

        $comment = Comment::where('id',$request->id)->first();
        if (! $comment) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $status = !$comment->approved;

        $this->commentServ->setActive($comment , $status);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }
        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();

    }


}
