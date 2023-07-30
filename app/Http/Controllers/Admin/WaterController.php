<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use App\Models\SouqProducts;
use App\Models\Order;
use App\Services\CategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Models\Market;
class WaterController extends AdminController
{

    use FileUpload;
    private $categoryServ;
    private $defaultLanguage;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServ = $categoryService;

        $this->share([
            'page' => Product::PAGE,
            'recordsCount' => Product::count(),
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }
    public function getAll($id){
        $products =  SouqProducts::where('shop_id' , 0)->where('category', 48)->get();
        if($products){
            return view('admin.water.index',['products'=> $products]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا المتجر"]]);
              return back();
         }
         
     }
     public function add(){
        return view('admin.water.create');
    }
     public function edit($local , $id){
         $product = SouqProducts::find($id);
         if($product){
            return view('admin.water.edit',['product'=> $product]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا المتجر"]]);
              return back();
         }
         
         
     }
    //طلبات الذبائح
  
    public function getAllWaterOrders(Request $request){
        $status = $request->route('type');
        if ($status == 6) {
            $orders = Order::with(['items', 'offer', 'user_data'])->where('type', 48)->orderBy('id', 'DESC');
        } else {
            $orders = Order::with(['items', 'offer', 'user_data'])->where('type', 48)->where('status', $status)->orderBy('id', 'DESC');
        }
    
        $from = null;
        $to = null;
        $shipper_id = 0;
        $user_id = 0;
    
        if ($request->isMethod('post')) {
    
            $from = $request->from;
            $to = $request->to;
            // $shipper_id = $request->shipper;
            $user_id = $request->user;
    
            if ($request->from != null) {$orders->whereDate('created_at', '>=', $request->from);}
            if ($request->to != null) {$orders->whereDate('created_at', '<=', $request->to);}
            // if ($request->shipper > 0) {$orders->where('shipper_id', '=', $request->shipper);}
            if ($request->user > 0) {$orders->where('user_id', '=', $request->user);}
        }
    
        $orders = $orders->get();
    
        $data = $orders;
        return view('admin.water.orders', compact(['data', 'status', 'from', 'to', 'user_id']));
       }
   
   public function OrderMeatRecieved(Request $request , $id){
    $order = Order::find($id);
    if(!$order){
        $this->flashAlert(['error' => ['msg' => "هذا الطلب غير موجود حاليا "]]);
        $request->flash();
        return back();
    }
    $order->status = 4;
    $result = $order->save();
   
    if($result == 1){
        $this->flashAlert(['success' => ['msg' => 'تم توصيل الطلب بنجاح']]);
        $request->flash();
        return back();
    }else{
        $this->flashAlert(['error' => ['msg' => "عفوا لقد حدث خطأ ما "]]);
        $request->flash();
        return back();
    }
}
public function OrderMeatDelete($id){
    $order = Order::find($id);
    if(!$order){
        $this->flashAlert(['error' => ['msg' => "هذا الطلب غير موجود حاليا "]]);
        $request->flash();
        return back();
    }
    $result = $order->delete();
    if($result == 1){
        $this->flashAlert(['success' => ['msg' => 'تم حذف المنتج']]);
        return back();
    }else{
        $this->flashAlert(['error' => ['msg' => "عفوا لقد حدث خطأ ما "]]);
        return back();
    }
    
}
//end of meat orders
    
}
