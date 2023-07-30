<?php

namespace App\Http\Controllers\Admin;
use App\Models\Shop;
use App\Models\Market;
use App\Models\ShopCates;
use App\Models\SouqProducts;
use App\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileUpload;
 use Auth;
 use App\Models\Order;
class TraderController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileUpload;

    private $categoryServ;
    private $defaultLanguage;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServ = $categoryService;

        $this->share([
            'page' => SouqProducts::PAGE,
            'recordsCount' => SouqProducts::count(),
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }
    public function moveOwnershipView($local , $id){
        $users = User::where('type_id', 4)->get();
        $shop = Shop::find($id);
        return view('admin.trader.ownership' , ['shop' => $shop, 'users' => $users]);
   }
   public function moveOwnership(Request $request , $local , $id){
    $shop = Shop::find($id);
    $shop->user_id = $request->user_id;
    $result = $shop->save();
    if($result){
        $this->flashAlert(['success' => ['msg' => 'نم نقل الملكيه بنجاح']]);
        $request->flash();
        return back();
    }else{
        $this->flashAlert(['error' => ['msg' => 'عفوا هناك خطأ ما في نقل الملكيه ']]);
        $request->flash();
        return back();
    }
   
  }
public function addMyProducts(){ 
    $shops = Shop::where('user_id' , Auth::id())->get();
    return view('admin.souqProducts.create' , ['shops' => $shops]);
}
    
   public function getOrdersOFTrader(Request $request ){
        // $status = $request->route('type');
        $id = Auth::id();
        $status = $_GET['type'];
        if($status == 6){
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('shipper_id', $id)->orderBy('id', 'DESC');
        }else{
            $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('shipper_id', $id)->where( 'status', $status)->orderBy('id', 'DESC');

        }

        // if ($status == 6) {
        //     $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('shop_id', $id)->orderBy('id', 'DESC');
        // } else {
        //     $orders = Order::with(['items', 'offer', 'shipper_data', 'user_data'])->where('status', $status)->orderBy('id', 'DESC');
        // }

        $from = null;
        $to = null;
        $shipper_id = 0;
        $user_id = 0;
if($request != null){
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
}
        

        $orders = $orders->get();

        $data = $orders;
        return view('admin.trader.orders', compact(['data', 'status', 'from', 'to', 'shipper_id', 'user_id','id']));
   }

    // get shops that added by specific user
    public function getByUserId(){
        $userid = Auth::id();
        $shops = Shop::where("user_id",$userid)->get();
        foreach($shops as $shop){
            $shopCates = explode(',' , $shop->category);
            $shop->category = "";
            foreach ($shopCates as  $value) {            
                $cate =ShopCates::find( $value);
                if($cate) {
                    $shop->category .=   $cate->title ." , ";
                }
            }
            $shop->category = trim($shop->category, ' ,');
           }
        if($shops){
            return view('admin.shops.index',['shops'=> $shops]);
         }else{
             $this->flashAlert(['error' => ['msg' => "هذا التاجر لا يملك محل  حاليا "]]);
            //  $request->flash();
              return back();
         }
    }
    public function getProductsOFShop($local,$id){
        $products = SouqProducts::where("category",0)->where('shop_id', $id)->get();

        if($products){
            return view('admin.souqProducts.index',['products'=> $products]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا هذا المتجر لا يوجد به منتجات حاليا"]]);
            //  $request->flash();
              return back();
         }
        
    }
   
    public function remove($id){

         $shop = Shop::find($id);
         $Result = $shop->delete();
       
         if($Result){
            $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
            // $request->flash();
            return back();
        }else{
            $this->flashAlert(['success' => ['msg' => __('messages.deleted_faild')]]);
            // $request->flash();
            return back();
        }
    }
}
