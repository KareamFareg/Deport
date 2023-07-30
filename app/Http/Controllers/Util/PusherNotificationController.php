<?php

namespace App\Http\Controllers\Util;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Notification;

class PusherNotificationController extends Controller
{

  public function send( Request $request )
  {

        // $user = \App\User::first();
        // 
        // $details = [
        //     'title' => 'Title',
        //     'body' => 'This is my first notification from ItSolutionStuff.com',
        //     'status' => '7',
        //     'order_id' => 200
        // ];


          event(new \App\Events\PusherNotification( $user->id,$user->name,'This is my first notification' ));
          // return view('admin.form');

  }
}
