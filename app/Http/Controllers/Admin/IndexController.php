<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Item;
use App\Models\Order;
use App\User;
use DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function __construct( )
    {

        $this->share([
            'page' => 'dashboard',
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }

    public function index()
    {

        $data = [];
        $data['clientCount'] = User::where(['type_id' => 2])->count();
        $data['clientCountActive'] = User::where(['type_id' => 2, 'is_active' => 1])->count();
        $data['clientCountInActive'] = User::where(['type_id' => 2, 'is_active' => 0])->count();
        if ($data['clientCount'] != 0) {
            $data['clientPercent'] = number_format($data['clientCountActive'] / $data['clientCount'] * 100, 0, '.', '');
        } else {
            $data['clientPercent'] = 0;
        }

        $data['shipperCount'] = User::where(['type_id' => 3])->count();
        $data['shipperCountActive'] = User::where(['type_id' => 3, 'is_active' => 1])->count();
        $data['shipperCountInActive'] = User::where(['type_id' => 3, 'is_active' => 0])->count();
        if ($data['shipperCount'] != 0) {
            $data['shipperPercent'] = number_format($data['shipperCountActive'] / $data['shipperCount'] * 100, 0, '.', '');
        } else {
            $data['shipperPercent'] = 0;
        }

        $data['adminCount'] = User::where(['type_id' => 1])->count();
        $data['adminCountActive'] = User::where(['type_id' => 1, 'is_active' => 1])->count();
        $data['adminCountInActive'] = User::where(['type_id' => 1, 'is_active' => 0])->count();
        if ($data['adminCount'] != 0) {
            $data['adminPercent'] = number_format($data['adminCountActive'] / $data['adminCount'] * 100, 0, '.', '');
        } else {
            $data['adminPercent'] = 0;
        }

        $data['itemsCount'] = Item::count();
        $data['itemsCouponsCount'] = Item::where('type_id', 2)->count();
        $data['itemsOffersCount'] = Item::where('type_id', 1)->count();
        $data['itemsDeletedCount'] = Item::where('is_active', 0)->count();
        $data['itemsViewedCount'] = Item::sum('views');
        $data['itemsLikedCount'] = Item::sum('likes');

        $data['orders1'] = Order::where(['status' => 1])->orderBy('id', 'desc')->limit(10)->get();
        $data['orders2'] = Order::where(['status' => 2])->orderBy('id', 'desc')->limit(10)->get();
        $data['orders3'] = Order::where(['status' => 3])->orderBy('id', 'desc')->limit(10)->get();
        $data['orders4'] = Order::where(['status' => 4])->orderBy('id', 'desc')->limit(10)->get();
        $data['orders5'] = Order::where(['status' => 5])->orderBy('id', 'desc')->limit(10)->get();

        $data['messages'] = ContactUs::with(['type', 'user:id,name,phone'])->select('id', 'title', 'mobile', 'contact_us_type_id', 'ip', 'user_id', 'created_at')->orderBy('id', 'desc')->limit(10)->get();

        return view('admin.index', $data);
    }

    public function order_chart(Request $request)
    {

        $order = new Order;
        if ($request->from != null) {
            $order = $order->whereDate('created_at', '>', $request->from);
        }
        if ($request->to != null) {
            $order = $order->whereDate('created_at', '<', $request->to);
        }

        $data['ordersCount6'] = $order->count();
        $all_count=$order->get()->groupBy('status');


        $data['ordersCount1'] = (isset($all_count[1])) ? $all_count[1]->count() : 0;
        $data['ordersCount2'] = (isset($all_count[2])) ? $all_count[2]->count() : 0;
        $data['ordersCount3'] = (isset($all_count[3])) ? $all_count[3]->count() : 0;
        $data['ordersCount4'] = (isset($all_count[4])) ? $all_count[4]->count() : 0;
        $data['ordersCount5'] = (isset($all_count[5])) ? $all_count[5]->count() : 0;
        

       if ($data['ordersCount6'] != 0) {
            $data['ordersPercent1'] = number_format($data['ordersCount1'] / $data['ordersCount6'] * 100, 1, '.', '');
            $data['ordersPercent2'] = number_format($data['ordersCount2'] / $data['ordersCount6'] * 100, 1, '.', '');
            $data['ordersPercent3'] = number_format($data['ordersCount3'] / $data['ordersCount6'] * 100, 1, '.', '');
            $data['ordersPercent4'] = number_format($data['ordersCount4'] / $data['ordersCount6'] * 100, 1, '.', '');
            $data['ordersPercent5'] = number_format($data['ordersCount5'] / $data['ordersCount6'] * 100, 1, '.', '');
        } else {
            $data['ordersPercent1'] = 0;
            $data['ordersPercent2'] = 0;
            $data['ordersPercent3'] = 0;
            $data['ordersPercent4'] = 0;
            $data['ordersPercent5'] = 0;
        }

        $html = view('admin.layouts.order_chart', $data)->render();

        if ($html) {
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        return response()->json(['status' => 'success', 'html' => 'No data']);
    }

    public function form()
    {
        return view('admin.form');
    }

}
