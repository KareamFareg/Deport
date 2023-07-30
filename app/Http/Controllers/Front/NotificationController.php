<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\NotificationService;
use App\Models\Notification;


class NotificationController extends Controller
{

  private $notificationServ;

  public function __construct(NotificationService $notificationService)
  {
      $this->notificationServ = $notificationService;
  }


  public function updateReadAt(Request $request)
  {

    $data = $this->notificationServ->updateReadAt($request->id);

    return response()->json(['status' => 'success']);

    // // success
    // $response = [
    //      'message' => [ 'sucess' => [trans('messages.updated')] ],
    // ];
    // return $this->responseSuccess($response);

  }





}
