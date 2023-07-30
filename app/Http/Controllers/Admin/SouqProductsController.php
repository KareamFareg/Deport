<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Product;
use App\Models\Shop;
use App\Services\CategoryService;
use App\Models\SouqProducts;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileUpload;

class SouqProductsController extends Controller
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
    public function add(){
        $shops= Shop::all();
        return view('admin.souqProducts.create', ['shops' => $shops]);
    }
    public function getAll($id){
        $products =  SouqProducts::where('category' , 0)->get();
        if($products){
            return view('admin.souqProducts.index',['products'=> $products]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا المتجر"]]);
              return back();
         }
         
     }
    //  public function getAllMeat(){
    //     $products =  SouqProducts::where('shop_id',0)->get();
    //       return response()->json([
    //          "code"=>200,'status' => "sucess",
    //          "message"=>"كل الزبائح",
    //          "data"=>$products
    //     ]);
         
    //  }
     public function edit($local, $id){
         $product = SouqProducts::find($id);
         if($product){
            return view('admin.souqProducts.edit',['product'=> $product]);
         }else{
             $this->flashAlert(['error' => ['msg' => "عفوا لا توجد منتجات متاحه حاليا في هذا المتجر"]]);    
              return back();
         }
         
         
     }
     // get products that added by specific user
    //  public function getAllByShopId($shop_id){
    //      $products = SouqProducts::where("shop_id",$shop_id)->get();
    //      if($products){
    //          return response()->json([
    //              "code"=>200,'status' => "sucess",
    //              "message"=>"get product by souq id",
    //              "data"=>[$products]
    //           ]);
    //      }else{
    //          return response()->json([
    //              "code"=>200,'status' => "error",
    //              "message"=>"there is no products added yet",
    //              "data"=>[]
    //           ]);
    //      }
         
         
    //  }
     
     public function create(Request $request)
     {
      
         $rules = [
             'title'=>'required',
             'Shop_id'=>'nullable|numeric',
             'price' => 'numeric',
             'offer_id' => 'numeric',
             'describe'=>'nullable|string',
             'category'=>'nullable|numeric'
             
             
         ];

         $validation = Validator::make($request->all() ,  $rules);
         if ($validation->fails()){
             return redirect()->back()->withErrors($validation)->withInputs($request->all());
         }else
         {
             $product = new SouqProducts();
             $product->title    = $request->title;
             $product->price    = $request->price;
             $product->describe    = $request->describe;
             if(isset($request->Shop_id) && $request->Shop_id != 0){ $product->Shop_id  = $request->Shop_id; $product->category  =0;} 
                 elseif(!isset($request->Shop_id) || $product->Shop_id == 0 ){$product->Shop_id  =0; $product->category = $request->category ;  }
             if(isset($product->describe  )){ $product->describe  = $request->describe; } 
              if(isset( $request->offer_id)){ $product->offer_id    = $request->offer_id;}         
            

            //  $product->image    = $this->saveImage($request->image, 'products');
             $product->save();
             if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'image',
                    'folder' => SouqProducts::FILE_FOLDER,
                    'recordId' => $product->id,
                ]);
                $product->Update(['image' => $path]);
            }
                 $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
                    $request->flash();
                    return back();
                    
                
         }
     }
 
 
     public function update(Request $request,$local,$id){
        
         $rules = [
            'title'=>'string',
            'Shop_id'=>'nullable|numeric',
            'price' => 'numeric',
            'offer_id' => 'numeric',
            'describe' => 'nullable|string'
         ];
         $validation = Validator::make($request->all() ,  $rules);
         if ($validation->fails()){
             return redirect()->back()->withErrors($validation)->withInputs($request->all());
         }else
         {
             $product =  SouqProducts::find($id);
             if(isset($request->title)){$product->title    = $request->title;}
             if(isset($request->price)){$product->price    = $request->price;}
             if(isset($product->Shop_id  ) && $product->Shop_id != 0){
                if(isset($request->Shop_id  )) {
                    $product->Shop_id  = $request->Shop_id; 
                }
                 
                }elseif( $product->Shop_id == 0){
                    if(isset($request->category)){
                         $product->Shop_id  =0;
                         $product->category = $request->category;
                    }
                   
                }
             if(isset($request->describe  )){ $product->describe  = $request->describe; } 
              if(isset( $request->offer_id)){ $product->offer_id    = $request->offer_id;}  
                         
            $product->save();
             if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' =>'image',
                    'folder' => SouqProducts::FILE_FOLDER,
                    'recordId' => $product->id,
                ]);
                
            }else{
            $path = $product->icon;
            }
            // $product->Update(['icon' => $path]);
            $product->image = $path;
            $product->save();
               $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
                $request->flash();
                return back();
 
            
         }
     }
 
     public function remove($local, $id){
       
          $product = SouqProducts::find($id);
          if($product == null){
            $this->flashAlert(['error' => ['msg' => __('messages.deleted_faild')]]);
            return back();
          }
          $Result = $product->delete();
        
          if($Result){
            $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
            return back();
        }else{
            $this->flashAlert(['error' => ['msg' => __('messages.deleted_faild')]]);
            return back();
        }
     } 
}
