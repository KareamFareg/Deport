<?php

namespace App\Http\Controllers\Api;
use App\Models\Shop;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ShopCates;
class ShopCategoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAll(){
       $cates =  ShopCates::all();
        return response()->json([
            "code"=>200,'status' => "sucess",
            "message"=>"all shop's Categories",
            "data"=>$cates
    ]);
        
    }
    public function getById($id){
        $cate = ShopCates::findOrFail($id);
        if($cate){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get shop Category by it's id",
                "data"=>$cate
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no shop Category added yet",
                "data"=>[]
             ]);
        }
        
        
    }
   
}
