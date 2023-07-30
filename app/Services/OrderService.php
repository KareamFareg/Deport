<?php

namespace App\Services;

use App\Models\Order;
use App\User;
use App\Models\OrderItem;
use App\Models\OrderOffer;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
class OrderService
{

    use FileUpload;
    private $notificationServ;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationServ = $notificationService;
    }

    public function store( $request )
    {

        $order = new Order();

        $user=User::find($request['user_id']);
        // $user = User::find(1);

        $user_static=['name'=>$user->name,'rate'=>$user->rate,'rate_count'=>$user->rate_count,'image'=>$user->imagePath()];
        $order->user_static = $user_static;
        // $order->referenceCode = $referenceCode;
        $order->user_id = $request['user_id'];
        if (isset($request['comment'])) {$order->comment = $request['comment'];} 
        if (isset($request['source_lat'])) {$order->source_lat = $request['source_lat'];}
        if (isset($request['source_lng'])) {$order->source_lng = $request['source_lng'];}
        if (isset($request['discount'])) {$order->discount = $request['discount'];}
        if (isset($request['shop_name'])) {$order->shop_name = $request['shop_name'];}
        if (isset($request['package_type'])) {$order->package_type = $request['package_type'];}
        if (isset($request['payment_type'])) {$order->payment_type = $request['payment_type'];}
        if (isset($request['addition_service'])) {
            $order->addition_service = $request['addition_service'];
            $order->addition_service_cost =\App\Models\Setting::find(1)->addition_service_cost;
        }
        $order->commission  =  \App\Models\Setting::find(1)->commission_percent ;
        if (isset($request['shop_id'])) {
            $order->shop_id = $request['shop_id'];
        } 
        if (isset($request['total'])) {
            $order->price =  $request['total'];
            $order->total = $request['total'] +  $order->commission  - $order->discount;
            $order->addition_service_cost = $order->total * \App\Models\Setting::find(1)->addition_service_cost;
            $order->total = $order->total + $order->addition_service_cost;
        }
        $order->destination_lng = $request['destination_lng'];
        $order->destination_lat = $request['destination_lat'];
        $order->type = $request['type'];
        $order->status = 1;
        $order->save();

        if (!$order) {
            return false;
        }

        $order->code = $order->id;
        //$order->access_user_id = $order->user_id;
        $order->save();
        if($order->type != 50){
            foreach ($request['items'] as $key=>$itemData) {
                $item = new OrderItem();
                $item->title = $itemData['title'];
                $item->order_id = $order->id;
                $item->quantity = $itemData['quantity'];
                if (isset( $itemData['price'] )) {
                    $item->price = $itemData['price'] * $itemData['quantity'];
                }
                // $item->price = $itemData['price'] * $itemData['quantity'];
                $item->save();

                $path = null;
                if (isset($itemData['image'])) {       
                    if(isset($_FILES['items']['name'][$key]['image']) ){
                        $path = $this->storeFile(false, [
                            'fileUpload' => $itemData['image'],
                            'folder' => OrderItem::FILE_FOLDER,
                            'recordId' => $item->id . '_image',
                        ]);
                    }else{
                    $path = $itemData['image'];
                        
                    }

                    // if ($path === false) {
                    //     $path = $itemData['image'];
                    // }
                }
                $item->image = $path;
                $item->save();
            }
    }

        if(isset($request['addition_service'])){
           $item->addition_service=1;
           $item->save();
        }

        $order = Order::with('items')->with('offer')->with('shipper_data')->with('user_data')->findOrFail($order->id);

        return $order;
    }

    public function updateStatus()
    {

    }

    public function submitOffer($request)
    {

        $offer =  OrderOffer::create($request);
        if (!$offer) {
            return false;
        }
        return $offer;

    }

    

}
