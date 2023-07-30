<?php

namespace App\Http\Controllers\Api;
use App\Models\Shop;
use App\Models\Market;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileUpload;
use App\Models\ShopCates;

class ShopController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileUpload;

    public function getAllMarkets(){
          $markets = Market::with('shops')->get();
          foreach($markets as $market){
            foreach ($market->shops as $shop) {
                $shopCates = explode(',' , $shop->category);
        $shop->category = "";
        foreach ($shopCates as  $value) {
            
            $cate =ShopCates::find( $value);
            if($cate){
                $shop->category .=   $cate->title ." , ";
            }
           
        }
        $shop->category = trim($shop->category, ' ,');
            }
          }
          return response()->json([
            "code"=>200,'status' => "sucess",
            "message"=>" كل الأسواق",
            "data"=>[$markets]
        ]);
    }

    public function getAll($souq_id){
       $shops =  Shop::where('souq_id',$souq_id)->get();
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
       if(!empty($shops)){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"كل المتاجرالموجوده داخل هذا السوق",
                "data"=>[$shops]
            ]);
       }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"عفوا لا توجد متاجر في هذا السوق",
                "data"=>[]
            ]);
       }
    }

    public function getById($id){
        $shop = Shop::find($id);
        if($shop){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get shop by it's id",
                "data"=>[$shop]
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no shops added yet",
                "data"=>[]
             ]);
        }
        
        
    }
    // get shops that added by specific user
    public function getByUserId($userid){
        $shops = Shop::where("user_id",$userid)->get();
        if($shops){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get shop by user id",
                "data"=>[$shops]
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no shops added yet",
                "data"=>[]
             ]);
        }   
    }
    public function getShopByCateId($id){
        $shops = Shop::where("category",'LIKE','%'.$id.'%')->get();
        foreach($shops as $shop){
            $shopCates = explode(',' , $shop->category);
            $shop->category = "";
            foreach ($shopCates as  $value) {
                
                $cate =ShopCates::find( $value);
                $shop->category .=   $cate->title ." , ";
            }
            $shop->category = trim($shop->category, ' ,');
           }
        if($shops){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get shop by category id id",
                "data"=>[$shops]
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no shops added yet",
                "data"=>[]
             ]);
        }  
        
    }
    
    public function create(Request $request)
    {
        $user = User::find($request->user_id);
        if($user->type_id != 4){
          return response()->json([
              "code"=>200,'status' => "error",
              "message"=>"عفوا انت لا تملك صلاحيه لاضافه اي محلات داخل السوق  ",
              "data"=>[]
          ]);
        }
        $rules = [
            'name'=>'required',
            'souq_id'=>'required',
            'icon'=>'required',
            'user_id'=>'required',
            'category'=>'numeric',
            
        ];
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            $shop = new Shop();
            $shop->name       = $request->name;
            $shop->user_id    = $request->user_id;
            $shop->souq_id    = $request->souq_id;
            $shop->category   = $request->category;
            $shop->save();
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'icon',
                    'folder' => Shop::FILE_FOLDER,
                    'recordId' => $shop->id,
                ]);
            }
                $shop->icon = $path;
                $Result = $shop->save();  
            

            if($Result==1)
            {
                return response()->json([
                    "code"=>200,'status' => "sucess",
                    "message"=>"تم الحفظ بنجاح",
                    "data"=>[$shop]
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
              "message"=>"عفوا انت لا تملك صلاحيه لاضافه اي محلات داخل السوق  ",
              "data"=>[]
           ]); 
        }
        $rules = [
            'name'=>'required|string',
            
        ];
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            $shop =  Shop::find($id);
            $shop->name    = $request->name;
            if($request->category){$shop->category    = $request->category;}
            if($request->user_id){$shop->user_id    = $request->user_id;}
            if($request->souq_id){$shop->souq_id    = $request->souq_id;}
        
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'icon',
                    'folder' => Shop::FILE_FOLDER,
                    'recordId' => $shop->id,
                ]);
                $shop->icon = $path;
            }
               
                $Result = $shop->save();
        

            if($Result==1)
            {
                return response()->json([
                    "code"=>200,'status' => "sucess",
                    "message"=>"تم الحفظ بنجاح",
                    "data"=>[$shop]
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

    public function remove(Request $request,$id){
        $user = User::find($request->user_id);
        if($user->type_id != 4){
          return response()->json([
              "code"=>200,'status' => "error",
              "message"=>"عفوا انت لا تملك صلاحيه لحذف اي محلات داخل هذا السوق  ",
              "data"=>[]
           ]); 
        }
         $shop = Shop::find($id);
         $Result = $shop->delete();
       
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
