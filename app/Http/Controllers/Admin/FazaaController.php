<?php

namespace App\Http\Controllers\admin;
use App\Models\Shop;
use App\Models\Fazaa;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ShopCates;
use Illuminate\Http\Request;
use App\Models\Order;

class FazaaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getAllFazaaOrders(Request $request){
        $status = $request->route('type');
        if ($status == 6) {
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('type', 6)->orderBy('id', 'DESC');
        } else {
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('type', 6)->where('status', $status)->orderBy('id', 'DESC');
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
        return view('admin.meat.orders', compact(['data', 'status', 'from', 'to', 'shipper_id', 'user_id']));
       }
      
    public function getAll(){
       $fazaa =  Fazaa::all();
       return view('admin.fazaa.index' , ['fazaa' => $fazaa]);
        
    }
   
public function remove($local , $id){
    $fazaa  = Fazaa::findOrFail($id);
    $Result = $fazaa->delete();
    if($Result){
        $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
        return back();
    }else{
        $this->flashAlert(['success' => ['msg' => __('messages.deleted_faild')]]);
        return back();
    }
}
    
    
   
}
