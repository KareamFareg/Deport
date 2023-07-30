<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Traits\Fcm;
use Notification;

class AdminNotificationController extends Controller
{

  use Fcm;

  

    public function create()
    {

      $user = \App\User::first();

      $details = [
          'title' => 'Title',
          'body' => 'This is my first notification from ItSolutionStuff.com',
          'status' => '7',
          // 'actionURL' => url('/'),
          'order_id' => 200
      ];

        Notification::send($user, new \App\Notifications\Main($details));

        // event(new \App\Events\AdminNotification( [ 'a' => 'hello world'] ));
        // return view('admin.form');
    }


    public function sendFcmWeb(Request $request)
    {

        return $this->sendFcmForWeb($request->t,$request->data);
    }

}
