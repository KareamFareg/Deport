<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\SouqProducts;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileUpload;

class ProductsController extends Controller
{
 use FileUpload;
    public function getAll($id){
        $products =  SouqProducts::where('shop_id' , $id)->get();
         return response()->json([
             "code"=>200,'status' => "sucess",
             "message"=>"all products",
             "data"=>$products
     ]);
         
     }
     public function getByCategoryId($id){
        $products =  SouqProducts::where('category' , $id)->get();
         return response()->json([
             "code"=>200,'status' => "sucess",
             "message"=>"all products",
             "data"=>$products
     ]);
         
     }
    //  public function getAllMeat(){
    //     $products =  SouqProducts::where('shop_id',0)->get();
    //       return response()->json([
    //          "code"=>200,'status' => "sucess",
    //          "message"=>"كل الزبائح",
    //          "data"=>$products
    //     ]);
         
    //  }
     public function getById($id){
         $product = SouqProducts::find($id);
         if($product){
             return response()->json([
                 "code"=>200,'status' => "sucess",
                 "message"=>"get product by it's id",
                 "data"=>$product
              ]);
         }else{
             return response()->json([
                 "code"=>200,'status' => "error",
                 "message"=>"there is no products added yet",
                 "data"=>[]
              ]);
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
        $user = User::find($request->user_id);
      if($user->type_id != 4){
        return response()->json([
            "code"=>200,'status' => "error",
            "message"=>"عفوا انت لا تملك صلاحيه لاضافه منتجات لهذا المحل",
            "data"=>[]
        ]);
      }
         $rules = [
             'title'=>'required',
             'Shop_id'=>'nullable|numeric',
             'price' => 'numeric',
             'offer_id' => 'numeric',
             'describe'=>'nullable|string'
             
             
         ];

         $validation = Validator::make($request->all() ,  $rules);
         if ($validation->fails()){
             return redirect()->back()->withErrors($validation)->withInputs($request->all());
         }else
         {
             $product = new SouqProducts();
             $product->title    = $request->title;
             $product->price    = $request->price;
             if(isset($product->Shop_id  ) && $product->Shop_id != 0){ $product->Shop_id  = $request->Shop_id; } 
                 elseif( $product->Shop_id == 0){$product->Shop_id  =0; $product->user_id = $request->user_id ;}
             if(isset($product->describe  )){ $product->describe  = $request->describe; } 
              if(isset( $request->offer_id)){ $product->offer_id    = $request->offer_id;}         
            

             $product->image    = $this->saveImage($request->image, 'products');
             $product->save();
             if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'image',
                    'folder' => SouqProducts::FILE_FOLDER,
                    'recordId' => $product->id,
                ]);
            }
                $product->image = $path;
                $Result = $product->save();  
            
             if($Result==1)
             {
                 return response()->json([
                     "code"=>200,'status' => "sucess",
                     "message"=>"تم الحفظ بنجاح",
                     "data"=>[$product]
             ]);
             }
             else
             {
                 return response()->json([
                     "code"=>200,'status' => "error",
                     "message"=>"هناك خطأ",
                     "data"=>[]
             ]);
 
             } 
         }
     }
 
 
     public function update(Request $request,$id){
        $user = User::find($request->user_id);
        if($user->type_id != 4){
          return response()->json([
              "code"=>200,'status' => "error",
              "message"=>"عفوا انت لا تملك صلاحيه لتعديل منتجات لهذا المحل",
              "data"=>[]
            ]);
        }
         $rules = [
            'title'=>'required',
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
             $product->title    = $request->title;
             $product->price    = $request->price;
             if(isset($product->Shop_id  ) && $product->Shop_id != 0){ $product->Shop_id  = $request->Shop_id; } elseif( $product->Shop_id == 0){$product->Shop_id  =0;}
             if(isset($product->describe  )){ $product->describe  = $request->describe; } 
              if(isset( $request->offer_id)){ $product->offer_id    = $request->offer_id;}  
                         
             $Result = $product->save();
             if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'image',
                    'folder' => SouqProducts::FILE_FOLDER,
                    'recordId' => $product->id,
                ]);
            }
                $product->image = $path;
                $Result = $product->save();  
            
             
             $Result = $product->save();
 
             if($Result==1)
             {
                 return response()->json([
                     "code"=>200,'status' => "sucess",
                     "message"=>"تم الحفظ بنجاح",
                     "data"=>[$product]
             ]);
             }
             else
             {
                 return response()->json([
                     "code"=>200,'status' => "error",
                     "message"=>"هناك خطأ",
                     "data"=>[]
             ]);
 
             } 
         }
     }
 
     public function remove($id){
        $user = User::find($request->user_id);
      if($user->type_id != 4){
        return response()->json([
            "code"=>200,'status' => "error",
            "message"=>"عفوا انت لا تملك صلاحيه لحذف اي منتجات لهذا المحل",
            "data"=>[]
        ]);
      }
          $product = SouqProducts::find($id);
          $Result = $product->delete();
        
          if($Result==1)
          {
              return response()->json([
                  "code"=>200,'status' => "sucess",
                  "message"=>"تم الحذف بنجاح",
                  "data"=>[]
          ]);
          }
          else
          {
              return response()->json([
                  "code"=>200,'status' => "error",
                  "message"=>"هناك خطأ",
                  "data"=>[]
          ]);
         }
     } 
}
