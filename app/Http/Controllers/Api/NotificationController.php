<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\User;
use App\Traits\FcmNot;

class NotificationController extends Controller
{

    use ApiResponse,FcmNot;
    private $notificationServ;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationServ = $notificationService;
    }

    public function getNotificationByUserId($id)
    {

        $data = $this->notificationServ->getNotificationByUserId($id);
        // if ($data->isEmpty()) {
        //     throw new ModelNotFoundException;
        // }

        return $this->responseSuccessPages(['data' => NotificationResource::collection($data)], $data);

    }
 public function getAdminNewNotifications($id)
    {

        $data = $this->notificationServ->getAdminNewNotifications($id);
//        dd( NotificationResource::collection($data));
        // if ($data->isEmpty()) {
        //     throw new ModelNotFoundException;
        // }

        return $this->responseSuccess(['data' => NotificationResource::collection($data)], $data);

    }



    //notfy between user and driver
    public function notifyUserDriverChat(Request $request)
    {

        $this->validate($request, [
            'order_id' => 'required|numeric|exists:orders,id',
        ]);

         $this->notificationServ->notifyDriverChat($request);

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }

    public function send_notification(Request $request)
    {

        $this->validate($request, [
            'order_id' => 'required|numeric|exists:orders,id',
        ]);

         $this->notificationServ->notifyOrder(
            ['fcm', 'db'],
            ['order_id' => $request->order_id, 'users' => $request->users]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }
    public function send_notification_orders(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|numeric|exists:users,id',
        ]);

         $this->notificationServ->notifyOrders(
            ['fcm', 'db'],
            ['orders' => $request->orders, 'user_id' => $request->user_id]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }

    public function chat(Request $request)
    {

        $this->validate($request, [
            'order_id' => 'required|numeric|exists:orders,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);

         $this->notificationServ->notifyChat(
            ['fcm', 'db'],
            ['order_id' => $request->order_id, 'user_id' => $request->user_id]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }


    public function adminChat(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|numeric|exists:users,id',
        ]);

         $this->notificationServ->notifyAdminChat(
            ['fcm', 'db'],
            ['user_id' => $request->user_id]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }
    public function send_order_notification(Request $request)
    {
    
          
        $this->validate($request, [
            'order_id' => 'required|numeric|exists:orders,id',
        ]);

         $this->notificationServ->notifyCreateOrderByUserId(
            ['fcm', 'db'],
            ['order_id' => $request->order_id, 'users' => $request->users]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);

    }
    public function notifyChatFromAdmin(Request $request,$id)
    {
    

         $this->notificationServ->notifyChatFromAdmin(
            ['fcm', 'db'],
            ['user_id' => $id]
        );

        $response = ['message' => ['sucess' => trans('messages.added')]];
        return $this->responseSuccess($response);
    }

    public function updateReadAt($id)
    {

        $data = $this->notificationServ->updateReadAt($id);

        // success
        $response = [
            'message' => ['sucess' => [trans('messages.updated')]],
        ];
        return $this->responseSuccess($response);

    }

    public function updateReadAllAt($id)
    {

        $data = $this->notificationServ->updateReadAllAt($id);

        // success
        $response = [
            'message' => ['sucess' => [trans('messages.updated')]],
        ];
        return $this->responseSuccess($response);

    }

}
