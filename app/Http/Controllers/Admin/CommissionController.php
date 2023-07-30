<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Commission;
use App\Models\CommissionTranaction;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

class CommissionController extends AdminController
{
    public function __construct()
    {
        $this->share([
            'page' => Commission::PAGE,
            'recordsCount' => '',
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }

    public function index(Request $request)
    {
        $orders = Order::where(['status' => 4]);
        $from = null;
        $to = null;

        if ($request->isMethod('post')) {

            //return $request;
            $from = $request->from;
            $to = $request->to;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
        }

        $orders->get();

        $shippersIds = $orders->pluck('shipper_id');
        $ordersIds = $orders->pluck('id');

        $shippers = User::whereIn('id', $shippersIds)->get();

        // echo 'orders price : ' . $shippers->first()->orders_price($ordersIds, 0) . ' <br> ';
        // echo 'shipping price : ' . $shippers->first()->shipping_price($ordersIds, 0) . ' <br>';
        // echo 'commission : ' . $shippers->first()->commission($ordersIds, 0) . ' <br> ';
        // echo 'shipper amount : ' . $shippers->first()->shipper_amount($ordersIds, 0) . ' <br> ';
        // echo 'discount : ' . $shippers->first()->discount($ordersIds, 0) . ' <br> ';
        // echo 'cash : ' . $shippers->first()->payment($ordersIds, 1, 0) . ' <br> ';
        // echo 'walet : ' . $shippers->first()->payment($ordersIds, 2, 0) . ' <br> ';
        // echo 'online : ' . $shippers->first()->payment($ordersIds, 3, 0) . ' <br> ';
        // echo 'deserved amount : ' . $shippers->first()->deserved_amount($ordersIds, 0) . ' <br> ';

        return view('admin.commissions.index', compact(['shippers', 'ordersIds', 'from', 'to']));

    }

    public function paid(Request $request)
    {
        $orders = Order::where(['status' => 4, 'commission_status' => 1]);
        $from = null;
        $to = null;
        $shipper = 0;
        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
        }

        $orders->get();
        $shippersIds = $orders->pluck('shipper_id');
        $ordersIds = $orders->pluck('id');
        $shippers = User::whereIn('id', $shippersIds)->get();
        return view('admin.commissions.paid', compact(['shippers', 'ordersIds', 'from', 'to','shipper']));

    }

    public function not_paid(Request $request)
    {
        $orders = Order::where(['status' => 4, 'commission_status' => 0]);
        $from = null;
        $to = null;
        $shipper = 0;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;
            $shipper = $request->shipper;

            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
        }

        $orders->get();

        $shippersIds = $orders->pluck('shipper_id');
        $ordersIds = $orders->pluck('id');
        $shippers = User::whereIn('id', $shippersIds)->get();

        return view('admin.commissions.not_paid', compact(['shippers', 'ordersIds', 'from', 'to', 'shipper']));

    }

    public function requests(Request $request)
    {
        $commissions = CommissionTranaction::orderBy('id', 'desc');

        $from = null;
        $to = null;
        $shipper = 0;

        if ($request->isMethod('post')) {

            $from = $request->from;
            $to = $request->to;
            $shipper = $request->shipper;

            if ($request->from != null) {$commissions->whereDate('date', '>=', $request->from);}
            if ($request->to != null) {$commissions->whereDate('date', '<=', $request->to);}
            if ($request->shipper > 0) {$commissions->where('user_id', '=', $request->shipper);}
        }

        $commissions = $commissions->orderBy('id','desc')->get();

        return view('admin.commissions.requests', compact(['commissions', 'from', 'to', 'shipper']));

    }

    public function accept(Request $request)
    {

        
        $commission=CommissionTranaction::find($request->route('id'));

        if ($commission->update(['status'=>1])) {
            Order::where(['status' => 4, 'commission_status' => 0,'shipper_id'=>$commission->user_id])->update(['commission_status' => 1]);
            $this->flashAlert(['success' => ['msg' => __('commission.accepted')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();

        return back();
    }

    public function cancel(Request $request)
    {

        if (CommissionTranaction::find($request->route('id'))->update(['status'=>2])) {
            $this->flashAlert(['success' => ['msg' => __('commission.canceled')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }


        $request->flash();

        return back();
    }

}
