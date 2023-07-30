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
class GasController extends AdminController
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
        $products =  SouqProducts::where('shop_id' , 0)->where('category', 6)->get();
        if($products){
            return view('admin.gas.index',['products'=> $products]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا القسم"]]);
              return back();
         }
         
     }
     public function add(){
        return view('admin.gas.create');
    }
     public function edit($local , $id){
         $product = SouqProducts::find($id);
         if($product){
            return view('admin.gas.edit',['product'=> $product]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا القسم"]]);
              return back();
         }
         
         
     }
    //طلبات الغاز
  
    public function getAllGasOrders(Request $request){
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
 

    
}
