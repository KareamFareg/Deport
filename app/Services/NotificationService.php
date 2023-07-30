<?php

namespace App\Services;

use App\Helpers\CommonHelper;
use App\Helpers\UtilHelper;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\Transaction;
use App\Traits\Fcm;
use App\User;
use App\Traits\FcmNot;


class NotificationService
{
    use Fcm,FcmNot;

    public $locale;

    // public function __construct()
    // {
    //     $this->locale =app()->getLocale();

    // }

    // public function __destruct() {
    //     dd($this->locale);
    //     app()->setLocale($this->locale) ;
    //  }

    public function notifyLike($to = [], $params = [])
    {

        $user_sender_id = $params['user_sender_id'];

        // get user sender
        $user_sender = User::where('id', $user_sender_id)->select('id', 'name')->first();
        // get current item
        $item = Item::where('id', $params['item_id'])->select('id', 'user_id')->first();
        // get woner of item
        $user_receiver = User::where('id', $item->user_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        // prepare for fcm
        $msg['user_sender'] = $user_sender_id;
        $msg['user_reciever'] = $user_receiver->id;
        $msg['item'] = $item->id;
        $msg['title'] = __('messages.new_like');
        $msg['body'] = __('messages.likes_your_post', ['user_name' => $user_sender->name]);

        // fcm
        if (in_array('fcm', $to)) {
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = $user_sender_id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'items';
            $data['table_id'] = $item->id;
            $data['type'] = 1; // like , 2 comment
            $data['data'] = __('messages.likes_your_post', ['user_name' => $user_sender->name]);
            $this->store($data);
        }

        // web
        if (in_array('web', $to)) {
            event(new \App\Events\MainNotification(
                $user_receiver->id,
                $user_sender->name,
                '1',
                route('items.show', ['id' => $item->id]),
                __('messages.likes_your_post', ['user_name' => $user_sender->name]) . ' : ' . UtilHelper::currentDate()
            )
            );
        }

    }

    public function notifyComment($to = [], $params = [])
    {

        $user_sender_id = $params['user_sender_id'];

        // get user sender
        $user_sender = User::where('id', $user_sender_id)->select('id', 'name')->first();
        // get current item
        $item = Item::where('id', $params['item_id'])->select('id', 'user_id')->first();
        // get woner of item
        $user_receiver = User::where('id', $item->user_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $parent_Comment_user = 0;
        if ($params['parent_id'] != 0) {
            $parentComment = Comment::where('id', $params['parent_id'])->select('user_id')->first();
            if ($parentComment) {
                $parent_Comment_user = $parentComment->user_id;
            }
        }

        // fcm
        if (in_array('fcm', $to)) {
            // send to post woner
            $msg['user_sender'] = $user_sender_id;
            $msg['user_reciever'] = $user_receiver->id;
            $msg['item'] = $item->id;
            $msg['title'] = __('messages.new_comment');
            $msg['body'] = __('messages.comments_your_post', ['user_name' => $user_sender->name]);
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}

            // send to parent comment woner
            if ($parent_Comment_user != 0) {
                $msg['user_sender'] = $user_sender_id;
                $msg['user_reciever'] = $parent_Comment_user; // parent comment woner
                $msg['item'] = $item->id;
                $msg['title'] = __('messages.new_comment');
                $msg['body'] = __('messages.comments_your_comment', ['user_name' => $user_sender->name]);
                // $response = $this->notifyFcm($user_receiver, $msg);
                $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                if ($response === false) {}
            }

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = $user_sender_id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'items';
            $data['table_id'] = $item->id;
            $data['type'] = 2; // like , 2 comment
            $data['data'] = __('messages.comments_your_post', ['user_name' => $user_sender->name]);
            $this->store($data);

            // send to parent comment woner
            if ($parent_Comment_user != 0) {
                $data['user_sender_id'] = $user_sender_id;
                $data['user_reciever_id'] = $parent_Comment_user; // parent comment woner
                $data['table_name'] = 'items';
                $data['table_id'] = $item->id;
                $data['type'] = 2; // like , 2 comment
                $data['data'] = __('messages.comments_your_comment', ['user_name' => $user_sender->name]);
                $this->store($data);
            }
        }

        // web
        if (in_array('web', $to)) {
            event(new \App\Events\MainNotification(
                $user_receiver->id,
                $user_sender->name,
                '2',
                route('items.show', ['id' => $item->id]),
                __('messages.comments_your_post', ['user_name' => $user_sender->name]) . ' : ' . UtilHelper::currentDate()
            )
            );

            // send to parent comment woner
            if ($parent_Comment_user != 0) {
                event(new \App\Events\MainNotification(
                    $parent_Comment_user,
                    $user_sender->name,
                    '2',
                    route('items.show', ['id' => $item->id]),
                    __('messages.comments_your_comment', ['user_name' => $user_sender->name]) . ' : ' . UtilHelper::currentDate()
                )
                );
            }
        }

    }

    public function notifyOrder($to = [], $params = [])
    {
        $users = $params['users'];

        foreach ($users as $user) {

            // get current item
            $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'code')->first();
            // get user sender
            $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

            $isSentBefore = Notification::where(['user_reciever_id' => $user['id'], 'data' => 'added_new_order', 'table_id' => $params['order_id']])->first();
            if (!$isSentBefore) {
                // get woner of item
                $user_receiver = User::where('id', $user['id'])->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                $this->change_locale($user_receiver->id);
                // fcm
                if (in_array('fcm', $to)) {
                    // prepare for fcm
                    $msg['user_sender'] = $user_sender->id;
                    $msg['user_reciever'] = $user_receiver->id;
                    $msg['order'] = $order->id;
                    $msg['type'] = 1;
                    $msg['title'] = __('messages.new_order');
                    $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->code]);
                    $msg['order_status'] = 1;
                    // $response = $this->notifyFcm($user_receiver, $msg);
                    $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                    if ($response === false) {}
                    // if ($response['result']['failure'] == 1 ){
                    //   return false;
                    // }
                }

                // db
                if (in_array('db', $to)) {
                    $data['user_sender_id'] = $user_sender->id;
                    $data['user_reciever_id'] = $user_receiver->id;
                    $data['table_name'] = 'orders';
                    $data['table_id'] = $order->id;
                    $data['type'] = 1; // order 1 , 2 chat
                    $data['data'] = 'added_new_order';
                    $data['title'] = 'new_order';
                    $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->code];
                    $data['order_status'] = 1;
                    $this->store($data);
                }
            }
        }
        app()->setLocale($this->locale);
    }
   
            // get current item
    public function notifySouqOrder($to = [], $params = [])
    {
        $user['id'] = $params['user_id'];
            // get current item
            $order = Order::where('id', $params['order_id'])->first();
            // get user sender
            $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

            $isSentBefore = Notification::where(['user_reciever_id' => $user['id'], 'data' => 'added_new_order', 'table_id' => $params['order_id']])->first();
            if (!$isSentBefore) {
                // get woner of item
                $user_receiver = User::where('id', $user['id'])->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                $this->change_locale($user_receiver->id);
                // fcm
                if (in_array('fcm', $to)) {
                    // prepare for fcm
                    $msg['user_sender'] = $user_sender->id;
                    $msg['user_reciever'] = $user_receiver->id;
                    $msg['order'] = $order->id;
                    $msg['type'] = 1;
                    $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                    $msg['title'] = __('messages.new_order');
                    $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->code]);
                    $msg['order_status'] = 1;
                    $response = $this->sendGFCMWeb($user['id'],$msg);
                    if ($response === false) {}
                    
                }

                // db
                if (in_array('db', $to)) {
                    $data['user_sender_id'] = $user_sender->id;
                    $data['user_reciever_id'] = $user_receiver->id;
                    $data['table_name'] = 'orders';
                    $data['table_id'] = $order->id;
                    $data['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                    $data['type'] = 1; // order 1 , 2 chat
                    $data['data'] = 'added_new_order';
                    $data['title'] = 'new_order';
                    $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->code];
                    $data['order_status'] = 1;
                    $this->store($data);
                }
               

            }
    
        app()->setLocale($this->locale);

    }
    public function notifyCreateOrderByUserId($to = [], $params = [])
    {
        $ids = $params['users'];

        foreach ($ids as $id) {

            // $user_receiver = User::where('id' , $id)->where('type_id' , 3)->where('is_active' , 1)->select('id', 'name', 'fcm_token', 'mobile_type')->get() ; 
            // $user_receiver = User::where('id', $id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

            // get current item
            $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'code')->first();
            // get user sender
            $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

            $isSentBefore = Notification::where(['user_reciever_id' => $id, 'data' => 'added_new_order', 'table_id' => $params['order_id']])->first();
            if (!$isSentBefore) {
                // get woner of item
                $user_receiver = User::where('id', $id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                $this->change_locale($id);
                // fcm
                

                // db
                if (in_array('db', $to)) {
                    $data['user_sender_id'] = $user_sender->id;
                    $data['user_reciever_id'] = $user_receiver->id;
                    $data['table_name'] = 'orders';
                    $data['table_id'] = $order->id;
                    $data['type'] = 1; // order 1 , 2 chat
                    $data['data'] = 'added_new_order';
                    $data['title'] = 'new_order';
                    $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->code];
                    $data['order_status'] = 1;
                    $notfication_id = $this->store($data);
                }
                if (in_array('fcm', $to)) {
                    // prepare for fcm
                    // if($notfication_id == null){
                    //     $notfication_id = "";
                    // }
                    $msg['user_sender'] = $user_sender->id;
                    $msg['user_reciever'] = $id;
                    $msg['order'] = $order->id;
                    $msg['id'] = $notfication_id;
                    $msg['type'] = 1;
                    $msg['title'] = __('messages.new_order');
                    $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->code]);
                    $msg['order_status'] = 1;
                    // $response = $this->notifyFcm($user_receiver, $msg);
                    $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                    if ($response === false) {}
                    // if ($response['result']['failure'] == 1 ){
                    //   return false;
                    // }
                }
            }
        }
        app()->setLocale($this->locale);
    }
    public function notifyOrders($to = [], $params = [])
    {
        $orders = $params['orders'];

        foreach ($orders as $order) {
            $date=\Carbon\Carbon::now()->subDays(1);
            // get current item
            $order = Order::where('id', $order['id'])->where('shipper_id',null)->whereDate('created_at','>',$date)->select('id', 'user_id', 'code','created_at')->first();
            if ($order) {
                // get user sender
                $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

                $isSentBefore = Notification::where(['user_reciever_id' => $params['user_id'], 'data' => 'added_new_order', 'table_id' => $order['id']])->first();
                if (!$isSentBefore) {
                    // get woner of item
                    $user_receiver = User::where('id', $params['user_id'])->select('id', 'name', 'fcm_token', 'mobile_type')->first();

                    $this->change_locale($user_receiver->id);
                    // fcm
                    if (in_array('fcm', $to)) {
                        // prepare for fcm
                        $msg['user_sender'] = $user_sender->id;
                        $msg['user_reciever'] = $user_receiver->id;
                        $msg['order'] = $order->id;
                        $msg['type'] = 1;
                        $msg['title'] = __('messages.new_order');
                        $msg['body'] = __('messages.added_new_order', ['user_name' => $user_sender->name,'order_code' => $order->code]);
                        $msg['order_status'] = 1;
                        // $response = $this->notifyFcm($user_receiver, $msg);
                        $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                        if ($response === false) {}
                        // if ($response['result']['failure'] == 1 ){
                        //   return false;
                        // }
                    }

                    // db
                    if (in_array('db', $to)) {
                        $data['user_sender_id'] = $user_sender->id;
                        $data['user_reciever_id'] = $user_receiver->id;
                        $data['table_name'] = 'orders';
                        $data['table_id'] = $order->id;
                        $data['type'] = 1; // order 1 , 2 chat
                        $data['data'] = 'added_new_order';
                        $data['title'] = 'new_order';
                        $data['params'] = ['user_name' => $user_sender->name,'order_code' => $order->code];
                        $data['order_status'] = 1;
                        $data['created_at'] = $order->created_at;
                    return    $this->store($data);
                    }
                }
            }
        }
        app()->setLocale($this->locale);

    }

    public function notifyOrderAccepted($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id','code')->first();
        $offer = OrderOffer::findOrFail($params['offer_id']);

        // get user sender
        $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $offer->user_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale($user_receiver->id);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = $user_sender->id;
            $msg['user_reciever'] = $user_receiver->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = __('messages.order_accepted', ['order_code' => $order->code]);
            $msg['order_status'] = 1;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = $user_sender->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['data'] = 'order_accepted';
            $data['title'] = 'congrate';
            $data['params'] = ['order_code' => $order->code];
            $data['order_status'] = 2;
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }
    public function notifyOrderStatus($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        // get user sender
        $user_sender = User::where('id', $order->shipper_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $order->user_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale($user_receiver->id);

        if ($params['status'] == 2) {
            $body = __('messages.order_accepted', ['order_code' => $order->code]);
            $status = 2;
        }elseif ($params['status'] == 3) {
            $body = __('messages.order_on_way', ['order_code' => $order->code]);
            $status = 3;
        } else {
            $body = __('messages.order_delivered', ['order_code' => $order->code]);
            $status = 4;
        }

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = $user_sender->id;
            $msg['user_reciever'] = $user_receiver->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            $msg['order_status'] = $status;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = ($params['status'] == 3) ? 'order_on_way' : 'order_delivered';
            $data['params'] = ['order_code' => $order->code];
            $data['order_status'] = $status;
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifychangePayment($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        // get user sender
        $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale($user_receiver->id);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);
            $msg['title'] = __('messages.change_payment');
            $msg['body'] = '';
            $msg['order_status'] = 3;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);
            $data['title'] = 'change_payment';
            $data['data'] = 'change_payment';
            $data['params'] = [];
            $data['order_status'] = 3;
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyCancelOrder($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();
        if ($params['canceld_by'] == 1) {
            // get user sender
            $user_sender = User::where('id', $order->user_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

            // get woner of item
            $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        } else {
            // get user sender
            $user_receiver = User::where('id', $order->user_id)->select('id', 'name', 'fcm_token')->first();

            // get woner of item
            $user_sender = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        }

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_calnceled', ['order_code' => $order->code]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                  
            $msg['title'] = __('messages.sorry');
            $msg['body'] = $body;
            $msg['order_status'] = 5;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'sorry';
            $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                  
            $data['data'] = 'order_calnceled';
            $data['order_status'] = 5;
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyCancelOrderByAdmin($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

          // get user sender
          $user_receiver = User::where('id', $order->user_id)->select('id', 'name')->first();

          $this->change_locale(optional($user_receiver)->id);
  
          $body = __('messages.order_calnceled', ['order_code' => $order->code]);
  
          if (in_array('fcm', $to)) {
              // prepare for fcm
              $msg['user_sender'] = 0;
              $msg['user_reciever'] = optional($user_receiver)->id;
              $msg['order'] = $order->id;
              $msg['type'] = 1;
              $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                  
              $msg['title'] = __('messages.sorry');
              $msg['body'] = $body;
              $msg['order_status'] = 5;
            //   $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

          }
  
          // db
          if (in_array('db', $to)) {
              $data['user_sender_id'] = 0;
              $data['user_reciever_id'] = optional($user_receiver)->id;
              $data['table_name'] = 'orders';
              $data['table_id'] = $order->id;
              $data['type'] = 1; // order 1 , 2 chat
              $data['title'] = 'sorry';
              $msg['link'] = route('admin.orders.show', ['id' => $order->id, 'locale' => app()->getLocale()]);                  
              $data['data'] = 'order_calnceled';
              $data['order_status'] = 5;
              $data['params'] = ['order_code' => $order->code];
              $this->store($data);
          }
          app()->setLocale($this->locale);


          //---------------------------------------------------------------------------//
        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_calnceled', ['order_code' => $order->code]);

        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = 0;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.sorry');
            $msg['body'] = $body;
            $msg['order_status'] = 5;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = 0;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'sorry';
            $data['data'] = 'order_calnceled';
            $data['order_status'] = 5;
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }
        app()->setLocale($this->locale);

      

    }
    public function notifyCompleteOrderByAdmin($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

          // get user sender
          $user_receiver = User::where('id', $order->user_id)->select('id', 'name')->first();

          $this->change_locale(optional($user_receiver)->id);
  
          $body = __('messages.order_delivered', ['order_code' => $order->code]);
  
          if (in_array('fcm', $to)) {
              // prepare for fcm
              $msg['user_sender'] = 0;
              $msg['user_reciever'] = optional($user_receiver)->id;
              $msg['order'] = $order->id;
              $msg['type'] = 1;
              $msg['title'] = __('messages.congrate');
              $msg['body'] = $body;
              $msg['order_status'] = 5;
            //   $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

          }
  
          // db
          if (in_array('db', $to)) {
              $data['user_sender_id'] = 0;
              $data['user_reciever_id'] = optional($user_receiver)->id;
              $data['table_name'] = 'orders';
              $data['table_id'] = $order->id;
              $data['type'] = 1; // order 1 , 2 chat
              $data['title'] = 'congrate';
              $data['data'] = 'order_delivered';
              $data['order_status'] = 5;
              $data['params'] = ['order_code' => $order->code];
              $this->store($data);
          }
          app()->setLocale($this->locale);


          //---------------------------------------------------------------------------//
        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_delivered', ['order_code' => $order->code]);

        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = 0;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            $msg['order_status'] = 5;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = 0;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = 'order_calnceled';
            $data['order_status'] = 5;
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }
        app()->setLocale($this->locale);

      

    }

    public function notifyAcceptOrderByAdmin($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

          // get user sender
          $user_receiver = User::where('id', $order->user_id)->select('id', 'name')->first();

          $this->change_locale(optional($user_receiver)->id);
  
          $body = __('messages.order_accepted', ['order_code' => $order->code]);
  
          if (in_array('fcm', $to)) {
              // prepare for fcm
              $msg['user_sender'] = 0;
              $msg['user_reciever'] = optional($user_receiver)->id;
              $msg['order'] = $order->id;
              $msg['type'] = 1;
              $msg['title'] = __('messages.congrate');
              $msg['body'] = $body;
              $msg['order_status'] = 2;
            //   $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

          }
  
          // db
          if (in_array('db', $to)) {
              $data['user_sender_id'] = 0;
              $data['user_reciever_id'] = optional($user_receiver)->id;
              $data['table_name'] = 'orders';
              $data['table_id'] = $order->id;
              $data['type'] = 1; // order 1 , 2 chat
              $data['title'] = 'congrate';
              $data['data'] = 'order_accepted';
              $data['order_status'] = 2;
              $data['params'] = ['order_code' => $order->code];
              $this->store($data);
          }
          app()->setLocale($this->locale);


          //---------------------------------------------------------------------------//
        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_accepted', ['order_code' => $order->code]);

        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = 0;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            $msg['order_status'] = 2;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = 0;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = 'order_accepted';
            $data['order_status'] = 2;
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }
        app()->setLocale($this->locale);

      

    }

    public function notifyOrderOnwayByAdmin($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

          // get user sender
          $user_receiver = User::where('id', $order->user_id)->select('id', 'name')->first();

          $this->change_locale(optional($user_receiver)->id);
  
          $body = __('messages.order_onway', ['order_code' => $order->code]);
  
          if (in_array('fcm', $to)) {
              // prepare for fcm
              $msg['user_sender'] = 0;
              $msg['user_reciever'] = optional($user_receiver)->id;
              $msg['order'] = $order->id;
              $msg['type'] = 1;
              $msg['title'] = __('messages.congrate');
              $msg['body'] = $body;
              $msg['order_status'] = 3;
            //   $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

          }
  
          // db
          if (in_array('db', $to)) {
              $data['user_sender_id'] = 0;
              $data['user_reciever_id'] = optional($user_receiver)->id;
              $data['table_name'] = 'orders';
              $data['table_id'] = $order->id;
              $data['type'] = 1; // order 1 , 2 chat
              $data['title'] = 'congrate';
              $data['data'] = 'order_onway';
              $data['order_status'] =3;
              $data['params'] = ['order_code' => $order->code];
              $this->store($data);
          }
          app()->setLocale($this->locale);


          //---------------------------------------------------------------------------//
        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale(optional($user_receiver)->id);

        $body = __('messages.order_onway', ['order_code' => $order->code]);

        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = 0;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            $msg['order_status'] = 3;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = 0;
            $data['user_reciever_id'] = optional($user_receiver)->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = 'order_onway';
            $data['order_status'] = 3;
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }
        app()->setLocale($this->locale);
    }
    public function notifyDeserveMore($to = [], $params = [])
    {

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        // get user sender
        $user_sender = User::where('id', $order->user_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $order->shipper_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale($order->shipper_id);
        $body = __('messages.order_deserve_more', ['order_code' => $order->code]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = 'order_deserve_more';
            $data['params'] = ['order_code' => $order->code];
            $this->store($data);
        }

        app()->setLocale($this->locale);

    }

    public function notifyRate($to = [], $params = [])
    {

        //$sender_id = $params['user_id'];
        $receiver_id = $params['user_id'];

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        if ($receiver_id == $order->user_id) {
            $sender_id = $order->shipper_id;
        } else {
            $sender_id = $order->user_id;
        }
        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $receiver_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        $this->change_locale($receiver_id);

        $body = __('messages.rate', ['order_code' => $order->code, 'user_name' => $user_sender->name]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 1;
            $msg['title'] = __('messages.congrate');
            $msg['body'] = $body;
            $msg['order_status'] = 4;

            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 1; // order 1 , 2 chat
            $data['title'] = 'congrate';
            $data['data'] = 'rate';
            $data['params'] = ['order_code' => $order->code, 'user_name' => $user_sender->name];
            $data['order_status'] = 4;
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }
    public function notifySubmitOffer($to = [], $params = [])
    {

        $sender_id = $params['user_id'];

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        $receiver_id = $order->user_id;

        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $receiver_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        $this->change_locale($receiver_id);

        $body = __('messages.offer_message', ['order_code' => $order->code, 'user_name' => $user_sender->name]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 6;
            $msg['title'] = __('messages.newOffer');
            $msg['body'] = $body;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 6; // order 1 , 2 chat
            $data['title'] = 'newOffer';
            $data['data'] = 'offer_message';
            $data['params'] = ['order_code' => $order->code, 'user_name' => $user_sender->name];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyChargeWallet($to = [], $params = [])
    {

        $receiver_id = $params['user_id'];

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        $sender_id = $order->shipper_id;

        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $receiver_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        $this->change_locale($receiver_id);

        $body = __('messages.charge_wallet_message', ['amount' => $params['amount'], 'user_name' => optional($user_sender)->name]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 7;
            $msg['title'] = __('messages.wallet_charged');
            $msg['body'] = $body;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 7; // order 1 , 2 chat
            $data['title'] = 'wallet_charged';
            $data['data'] = 'charge_wallet_message';
            $data['params'] = ['amount' => $params['amount'], 'user_name' => optional($user_sender)->name];
            $this->store($data);
        }
        app()->setLocale($this->locale);

        $data['title'] = 'wallet_charged';
        $data['amount'] = $params['amount'];
        $data['date'] = \Carbon\Carbon::now();
        $data['description'] = "charge_wallet_message";
        $data['user_id'] = $receiver_id;
        $data['user_name'] = optional($user_sender)->name;
        Transaction::create($data);

    }

    public function notifyChat($to = [], $params = [])
    {

        $receiver_id = $params['user_id'];

        // get current item
        $order = Order::where('id', $params['order_id'])->select('id', 'user_id', 'shipper_id', 'code')->first();

        if ($receiver_id == $order->user_id) {
            $sender_id = $order->shipper_id;
        } else {
            $sender_id = $order->user_id;
        }
        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $user_receiver = User::where('id', $receiver_id)->select('id', 'name', 'fcm_token', 'mobile_type', 'lang')->first();

        $lang = $user_receiver->lang;
        $locale = Language::where('locale', strip_tags($lang))->active()->first();

        $this->change_locale($receiver_id);

        $body = __('messages.chat_body', ['order_code' => $order->code, 'user_name' => $user_receiver->name]);

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = optional($user_sender)->id;
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['order'] = $order->id;
            $msg['type'] = 2;
            $msg['title'] = __('messages.new_chat');
            $msg['body'] = $body;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {}
            // if ($response['result']['failure'] == 1 ){
            //   return false;
            // }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order->id;
            $data['type'] = 2; // order 1 , 2 chat
            $data['title'] = 'new_chat';
            $data['data'] = 'chat_body';
            $data['params'] = ['order_code' => $order->code, 'user_name' => $user_receiver->name];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyChatFromAdmin($to = [], $params = [])
    {

        $receiver_id = $params['user_id'];

        // get woner of item
        $user_receiver = User::where('id', $receiver_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();

        $this->change_locale($receiver_id);

        $body = __('messages.chat_body_from_admin');

        // fcm
        if (in_array('fcm', $to)) {
            // prepare for fcm
            $msg['user_sender'] = '0';
            $msg['user_reciever'] = optional($user_receiver)->id;
            $msg['type'] = 4;
            $msg['title'] = __('messages.new_chat');
            $msg['body'] = $body;
            // $response = $this->notifyFcm($user_receiver, $msg);
            $response = $this->sendGCM($msg,$user_receiver->fcm_token);

            if ($response === false) {

            }

        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = 0;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = '0';
            $data['type'] = 4; // order 1 , 2 chat
            $data['title'] = 'new_chat';
            $data['data'] = 'chat_body_from_admin';
            $data['params'] = [];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyAdminChat($to = [], $params = [])
    {

        $sender_id = $params['user_id'];

        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $users_receiver = User::where('type_id', 1)->select('id', 'name', 'fcm_token', 'mobile_type')->get();

        foreach ($users_receiver as $user_receiver) {

            $this->change_locale($user_receiver->id);
            // fcm
            if (in_array('fcm', $to)) {
                // prepare for fcm
                $msg['user_sender'] = optional($user_sender)->id;
                $msg['user_reciever'] = optional($user_receiver)->id;
                $msg['order'] = '';
                $msg['type'] = 5;
                // $msg['link'] =  route('admin.messages.user' , [ 'id' =>optional($user_sender)->id] ) ;
                $msg['link'] = route('admin.messages.user', ['id' => optional($user_sender)->id, 'locale' => app()->getLocale()]);
                $msg['title'] = __('messages.new_chat');
                $msg['body'] = __('messages.admin_chat_body', ['user_name' => $user_sender->name]);
                // $response = $this->notifyFcm($user_receiver, $msg);
                $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                if ($response === false) {}
                // if ($response['result']['failure'] == 1 ){
                //   return false;
                // }
            }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = 0;
            $data['table_name'] = 'orders';
            $data['table_id'] = 0;
            $data['link'] = route('admin.messages.user', ['id' => optional($user_sender)->id, 'locale' => app()->getLocale()]);
            $data['type'] = 5; // order 1 , 2 chat
            $data['title'] = 'new_chat';
            $data['data'] = 'admin_chat_body';
            $data['params'] = ['user_name' => $user_sender->name];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }
   

    //notfy between user and driver
    public function notifyDriverChat( $request)
    {

        $sender_id = $request->sender_id;
        $reciever_id = $request->reciever_id;
        $message = $request->message;
        $order_id = $request->order_id;

        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();
        // get user reciever
        $user_receiver = User::where('id', $reciever_id)->select('id', 'name', 'fcm_token', 'mobile_type')->first();
        
            // $this->change_locale($user_receiver->id);
            // fcm
    
                // prepare for fcm
                $msg['user_sender'] = $user_sender->id;
                $msg['user_reciever'] = $user_receiver->id;
                $msg['order'] = '';
                $msg['type'] = 5;
                $msg['link'] =  route('admin.messages.user' , [ 'id' =>optional($user_sender)->id] ) ;
                $msg['title'] = __('messages.new_chat');
                $msg['body'] = __('messages.admin_chat_body', ['user_name' => $user_sender->name]);
                // $response = $this->notifyFcm($user_receiver, $msg);
                $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                if ($response === false) {}
                // if ($response['result']['failure'] == 1 ){
                //   return false;
                // }
    
            $data['user_sender_id'] = $user_sender->id;
            $data['user_reciever_id'] = $user_receiver->id;
            $data['table_name'] = 'orders';
            $data['table_id'] = $order_id;
            $data['type'] = 2; // order 1 , 2 chat
            $data['title'] = __('messages.new_chat');
            $data['data'] = $message;
            $data['params'] = ['order_code'=>$order_id,'user_name' => optional($user_sender)->name];
            $this->store($data);
     
        // app()->setLocale($this->locale);

    }
   
    public function notifyAdminContactUs($to = [], $params = [])
    {

        $sender_id = $params['user_id'];

        // get user sender
        $user_sender = User::where('id', $sender_id)->select('id', 'name')->first();

        // get woner of item
        $users_receiver = User::where('type_id', 1)->select('id', 'name', 'fcm_token', 'mobile_type')->get();

        foreach ($users_receiver as $user_receiver) {

            $this->change_locale($user_receiver->id);
            // fcm
            if (in_array('fcm', $to)) {
                // prepare for fcm
                $msg['user_sender'] = optional($user_sender)->id;
                $msg['user_reciever'] = optional($user_receiver)->id;
                $msg['order'] = '';
                $msg['type'] = 8;
                // $msg['link'] =  route('admin.messages.user' , [ 'id' =>optional($user_sender)->id] ) ;
                $msg['link'] = route('admin.contacts.index', ['locale' => app()->getLocale()]);
                $msg['title'] = __('messages.new_contact_us');
                $msg['body'] = __('messages.new_contact_us_body', ['user_name' => optional($user_sender)->name]);
                // $response = $this->notifyFcm($user_receiver, $msg);
                $response = $this->sendGCM($msg,$user_receiver->fcm_token);

                if ($response === false) {}
                // if ($response['result']['failure'] == 1 ){
                //   return false;
                // }
            }
        }

        // db
        if (in_array('db', $to)) {
            $data['user_sender_id'] = optional($user_sender)->id;
            $data['user_reciever_id'] = 0;
            $data['table_name'] = 'orders';
            $data['table_id'] = 0;
            $data['link'] = route('admin.contacts.index', ['locale' => app()->getLocale()]);
            $data['type'] = 8; // order 1 , 2 chat
            $data['title'] = 'new_contact_us';
            $data['data'] = 'new_contact_us_body';
            $data['params'] = ['user_name' => optional($user_sender)->name];
            $this->store($data);
        }
        app()->setLocale($this->locale);

    }

    public function notifyFcm($user, $data)
    {

        $validate = $this->validateFcmSend($user, $data);
        if ($validate !== true) {
            return $validate;
        }

        return $this->sendFcm($user->mobile_type, $user->fcm_token, $data);

    }

    public function validateFcmSend($user, $data)
    {

        if (!$user) {
            return 'Select User';
        }

        if (!$user->fcm_token) {
            return 'Token Not Found';
        }

        if (!$user->mobile_type) {
            return 'No Mobile Type Found';
        }

        return true;

    }

    public function store($data)
    {
        // store notification in db
       $notification= Notification::Create($data);
       if(isset($data['created_at'])){
        $notification->created_at=$data['created_at'];
         $notification->save();
        return $notification->id;
       }
       return $notification->id;
    }

    public function getNotificationByUserId($userId)
    {
        return Notification::with('user_sender', 'item_type')->where('user_reciever_id', $userId)->orderby('id', 'desc')->paginate(10);
    }
    public function getAdminNewNotifications($id)
    {
        return Notification::with('user_sender', 'item_type')->where(['user_reciever_id' => 0, 'read_at' => null])->where('id', '>', $id)->orderby('id', 'desc')->get();
    }

    public function getUnreadNotificationByUserId($userId)
    {
        return Notification::with('user_sender', 'item_type')->where('user_reciever_id', $userId)->Unread()->orderby('id', 'desc')->paginate(10);
    }

    public function updateReadAt($notificationId)
    {

        $notification = Notification::findOrFail($notificationId);
        $notification->update(['read_at' => UtilHelper::currentDate()]);

        return true;

    }

    public function updateReadAllAt($userId)
    {

        $notification = Notification::where(['user_reciever_id' => $userId]);
        $notification->update(['read_at' => UtilHelper::currentDate()]);

        return true;

    }

    public function notifyWeb($id)
    {

        // ??????????????????
        //
        // $user = User::find($id);
        //
        // $data['order_id'] = $order->id;
        // $data['title'] = __('order.status_2');
        // $data['body'] = $order->id . __('order.status_2');

        return $this->sendFcmWeb();

    }

    public function change_locale($id)
    {

        $this->locale = app()->getLocale();
        // get woner of item
        $user = User::where('id', $id)->select('lang')->first();

        $lang = optional($user)->lang;
        $locale = Language::where('locale', strip_tags($lang))->active()->first();

        if ($locale) {
            app()->setLocale($locale->locale);
        } else {
            // if not founded get default language
            $defaultLocale = CommonHelper::getDefultLanguage();
            app()->setLocale($defaultLocale->locale);
        }
    }

}
