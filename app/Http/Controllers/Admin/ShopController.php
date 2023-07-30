<?php

namespace App\Http\Controllers\admin;
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
class ShopController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileUpload;

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
    public function getAll(){
       $shops = Shop::all();
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
        return view('admin.shops.index', ['shops' => $shops]);
    }

    public function changeShopStatus($local,$id ,$status){
        $shop = Shop::find($id);
        if(!$shop){
             $this->flashAlert(['error' => ['msg' => "هذا المحل غير موجود حاليا "]]);
             $request->flash();
              return back();
         }
         $shop->approved = $status;
         $result = $shop->save();
         if($result){
            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            return back();
        }else{
            $this->flashAlert(['error' => ['msg' => __('messages.updated_faild')]]);
            return back();
        }

    }

    public function edit($local , $id){
        $shop = Shop::find($id);
        $categories = shopCates::all();
        $souqs = Market::all();

        if($shop){
           return view('admin.shops.edit',['shop'=> $shop,'categories'=>$categories,'souqs'=>$souqs]);
        }else{
            $this->flashAlert(['error' => ['msg' => "هذا المحل غير موجود حاليا "]]);
             return back();
        }
    }
    public function add(){
        $categories = ShopCates::all();
        $souqs = Market::all();
        return view('admin.shops.create',['categories' => $categories, 'souqs'=>$souqs]);
    }
    // get shops that added by specific user
    public function getByUserId(){
        $userid = Auth::id();
        $shops = Shop::where("user_id",$userid)->get();
        if($shops){
            return view('admin.shops.index',['shops'=> $shops]);
         }else{
             $this->flashAlert(['error' => ['msg' => "هذا التاجر لا يملك محل  حاليا "]]);
              return back();
         }
    }
    public function getProductsOFShop($local,$id){
        $products = SouqProducts::where("category",0)->where('shop_id', $id)->get();
        if($products){
            return view('admin.souqProducts.index',['products'=> $products]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا هذا المتجر لا يوجد به منتجات حاليا"]]);
              return back();
         }
        
    }
    
    public function create(Request $request)
    {
        $user = User::find($request->user_id);
        
        $rules = [
            'name'=>'required',
            'souq_id'=>'required',
            'icon'=>'required',
           
            
        ];
       
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            // $shop = Shop::create($request->all());

            $shop = new Shop();
            $shop->name       = $request->name;
            $shop->user_id    = Auth::id();
            $shop->souq_id    = $request->souq_id;
            if(isset($request->category)){
                foreach($request->category as $cate){
                    $shop->category .= $cate.",";
                }
            }else{
                $shop->category = 1;
            }
           
            $shop->save();
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' =>'icon',
                    'folder' => Shop::FILE_FOLDER,
                    'recordId' => $shop->id,
                ]);
               
            }else{
                $path = 'shops/default.jpg' ;
            }
            $shop->Update(['icon' => $path]);
            $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
                    $request->flash();
                    return back();
            

        }
    }


    public function update(Request $request,$local , $id){
     
        $user = User::find($request->user_id);
       
        $rules = [
            'name'=>'required|string',
        ];
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            $shop =  Shop::find($id);
            if(isset($request->name)){$shop->name  = $request->name;}   
            $shop->user_id    = Auth::id();
            // if($request->user_id){$shop->user_id    = $request->user_id;}
            if($request->souq_id){$shop->souq_id    = $request->souq_id;}
            if(isset($request->category)){
                $shop->category="";
                foreach($request->category as $cate){
                    $shop->category .= $cate.',';
                }
            }
            $shop->save();
            
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' =>'icon',
                    'folder' => Shop::FILE_FOLDER,
                    'recordId' => $shop->id,
                ]);
              
            }else{
                $path = $shop->icon ;
            }
            $shop->Update(['icon' => $path]);
            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
            $request->flash();
            return back();

            
        }
    }

    public function remove($local, $id){

         $shop = Shop::find($id);
         $Result = $shop->delete();
       
         if($Result){
            $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
            return back();
        }else{
            $this->flashAlert(['success' => ['msg' => __('messages.deleted_faild')]]);
            return back();
        }
    }
}
