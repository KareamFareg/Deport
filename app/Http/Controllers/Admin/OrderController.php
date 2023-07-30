<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Order;
use App\Models\Rate;
use App\Services\CategoryService;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Http\Request;
use PDF;
use DOMPDF;
use App\Services\NotificationService;

class OrderController extends AdminController
{

    private $orderServ;
    private $userServ;
    private $defaultLanguage;
    private $notificationServ;

    public function __construct(OrderService $orderService, UserService $userService, CategoryService $categoryService, NotificationService $notificationService)
    {
        $this->orderServ = $orderService;
        $this->userServ = $userService;
        $this->categoryServ = $categoryService;
        $this->notificationServ = $notificationService;

        $this->share([
            'page' => Order::PAGE,
            //'recordsCount' => Order::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();
    }

    public function index(Request $request)
    {

        $status = $request->route('type');
        if ($status == 6) {
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->orderBy('id', 'DESC');
        } else {
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('status', $status)->orderBy('id', 'DESC');
        }

        $from = null;
        $to = null;
        $shipper_id = 0;
        $user_id = 0;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;
            $shipper_id = $request->shipper;
            $user_id = $request->user;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
            if ($request->user > 0) {$orders->where('user_id', '=', $request->user);}
        }

        $orders = $orders->get();

        $data = $orders;
        return view('admin.orders.index', compact(['data', 'status', 'from', 'to', 'shipper_id', 'user_id']));

    }

    public function getClientOrders(Request $request)
    {

        $id = $request->route('id');
        $status = 6;

        $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('user_id', $id)->orderBy('id', 'DESC');

        $from = null;
        $to = null;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
            if ($request->status != 0) {$orders->where('status', '=', $request->status);}
        }

        $orders = $orders->get();

        $data = $orders;
        $subTitle = __('order.client_orders');
        return view('admin.orders.user_orders', compact(['data', 'status', 'subTitle', 'from', 'to', 'id']));

    }
    public function getShippertOrders(Request $request)
    {

        $id = $request->route('id');
        $status = 6;
        $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('shipper_id', $id)->orderBy('id', 'DESC');

        $from = null;
        $to = null;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
        }

        $orders = $orders->get();

        $subTitle = __('order.shipper_orders');
        $data = $orders;
        return view('admin.orders.user_orders', compact(['data', 'status', 'subTitle', 'from', 'to', 'id']));

    }

    public function show(Request $request)
    {

        $data = Order::with(['items','addition_items', 'offer', 'shipper_data', 'user_data'])->findOrFail($request->id);

        return view('admin.orders.show', compact(['data']));

    }

    public function pdf(Request $request)
    {

        $data = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->findOrFail($request->id);
        //return view('admin.orders.invoice', compact(['data']));
         $pdf = PDF::loadView('admin.orders.invoice', compact(['data']));
        // $pdf=  view('admin.orders.pdf', compact(['data']))->render();

      //  return $pdf->download('Invoice.pdf');
        return response()->download($pdf->download('Invoice.pdf'));

    }

    public function deleteOrders(Request $request)
    {
        try {
            Order::whereIn('id', $request->ids)->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
        return response()->json(['success' => __('messages.deleted')]);
    }

    public function rate(Request $request)
    {

        $id = $request->route('id');

        //$rates=Rate::where('order_id',$id)->orderBy('id','desc')->get();
        $data = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->findOrFail($request->id);
        $html = view('admin.orders.order_rate', compact(['data']))->render();

        if ($html) {
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        return response()->json(['status' => 'success', 'html' => 'No data']);

    }


    public function cancel(Request $request ){
        $id = $request->route('id');
        $order = Order::findOrFail($id);
        $order->status =4;
        $order->note=$request->note;
        $order->canceld_by = $request->canceld_by;
        $order->cancel_date = \Carbon\Carbon::now();
        $result= $order->save();
        if ($result == false) {           
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
            return back();

        }else{
             
              $this->notificationServ->notifyCancelOrderByAdmin(
                ['fcm', 'db'],
                ['order_id' => $id ]
            );

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            return back();
        }

    }
    public function complete(Request $request ){
        $id = $request->route('id');
        $order = Order::findOrFail($id);
        if($order->payment_status != 1){
            $this->flashAlert(['faild' => ['msg' => "عفوا العميل لم يكمل عمليه الدفع"]]);
            return back();

        }
        $order->status =4;
        $order->note=$request->note;
        $order->delivery_date = \Carbon\Carbon::now();
        $result= $order->save();
        if ($result == false) {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
            return back();

        }else{
             
              $this->notificationServ->notifyOrderStatus(
                ['fcm', 'db'],
                ['order_id' => $id ,'status'=>4]
            );

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            return back();
        }

    }
    public function accept(Request $request ){
        $id = $request->route('id');
        $order = Order::findOrFail($id);
        $order->status =2;
        $order->note=$request->note;
        $result= $order->save();
        if ($result == false) {

            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
            return back();

        }else{
             
              $this->notificationServ->notifyOrderStatus(
                ['fcm', 'db'],
                ['order_id' =>  $id ,'status'=>2]
            );

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            return back();
        }

    }
    public function OrderOnway(Request $request ){
        $id = $request->route('id');
        $order = Order::findOrFail($id);
        $order->status =3;
        $order->note=$request->note;
        $result= $order->save();
        if ($result == false) {

            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
            return back();

        }else{
             
              $this->notificationServ->notifyOrderStatus(
                ['fcm', 'db'],
                ['order_id' => $id ,'status'=>3]
            );

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            return back();
        }

    }
}
