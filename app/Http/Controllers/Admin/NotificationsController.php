<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\User;
use App\Traits\Fcm;
use App\Traits\FcmNot;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    use Fcm;

    public function notifyAll(Request $request)
    {
        $data['title'] = __('messages.notify_from_system',['title'=>$request->title]);
        $data['body'] = $request->message;
        $data['type'] = 3;
        $FCM = $this->sendFcmGroup($request->group, $data);

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();

    }


    public function notifyUser($id,Request $request)
    {

        $id = $request->route('id');

        $msg['user_sender'] = 0;
        $msg['user_reciever'] = $id;
        $msg['order'] = '';
        $msg['type'] = 10;
        $msg['title'] = __('messages.notify_from_system',['title'=>$request->title]);
        $msg['body'] = __('messages.notify_from_system_body', ['message' => $request->message]);



        $user=User::find($id);
        $this->sendGCM($user->mobile_type, $user->fcm_token, $msg);


        $data['user_sender_id'] = 0;
        $data['user_reciever_id'] = $id;
        $data['table_name'] = '';
        $data['table_id'] = 0;
        $data['type'] = 10; // order 1 , 2 chat
        $data['title'] = 'notify_from_system';
        $data['data'] = 'notify_from_system_body';
        $data['params'] = ['message' => $request->message ,'title'=>$request->title];

         Notification::Create($data);

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();

    }



    public function index(Request $request)
    {

        $notifications = Notification::query();
        // $notifications = Notification::where('user_reciever',  Auth::id())->get();
        if ($request->crit) {

            $notifications = $notifications->where('data', 'like', '%' . str_replace(' ', '%', $request->crit) . '%');
        }

        $notifications = $notifications->with('user_sender')->paginate(10);
        $request->flash();

        if ($request->ajax()) {
            return response()->json(array('status' => 'validation', 'html' => view('Admin.notifications.data', ['notifications' => $notifications])->render()));
        }
        return view('Admin.notifications.index', compact(['notifications']));
    }
}
