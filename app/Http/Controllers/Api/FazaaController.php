<?php

namespace App\Http\Controllers\Api;
use App\Models\Shop;
use App\Models\Fazaa;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ShopCates;
use Illuminate\Http\Request;

class FazaaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAll(){
       $fazaa =  Fazaa::all();
        return response()->json([
            "code"=>200,'status' => "sucess",
            "message"=>"all Fazaa help call",
            "data"=>$fazaa
    ]);
        
    }
    public function create(Request $request){
        $fazaa = new Fazaa();
        $fazaa->user_id = $request->user_id;
        $fazaa->lat = $request->lat;
        $fazaa->lng = $request->lng;
        $fazaa->note = $request->note;
        $result = $fazaa->save();

       if($result){
            return response()->json([
                "code"=>200,
                'status' => "sucess",
                "message"=>"تمت الاضافه بنجاح ",
                "data"=>$fazaa
            ]);
       }else{
            return response()->json([
                "code"=>200,
                'status' => "error",
                "message"=>"هناك خطأ ما يرجي المحاوله في وقت لاحق",
                "data"=>[]
            ]);
       }

     }

     public function update(Request $request ){
        $fazaa = Fazaa::find($request->id);
        $fazaa->user_id = $request->user_id;
        if($fazaa->lat){$fazaa->lat = $request->lat;}
        if($fazaa->lng){$fazaa->lng = $request->lng;}
        if($fazaa->note){$fazaa->note = $request->note;}
        $result = $fazaa->save();

       if($result){
            return response()->json([
                "code"=>200,
                'status' => "sucess",
                "message"=>"تمت التعديل بنجاح ",
                "data"=>$fazaa
            ]);
       }else{
            return response()->json([
                "code"=>200,
                'status' => "error",
                "message"=>"هناك خطأ ما يرجي المحاوله في وقت لاحق",
                "data"=>[]
            ]);
       }

     }

     
    public function getById($id){
        $fazaa = Fazaa::findOrFail($id);
        if($fazaa){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get help call by it's id",
                "data"=>$fazaa
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no help call added yet",
                "data"=>[]
             ]);
        }
        
        
    }
    public function getByUserId($id){
        $fazaa = Fazaa::where('user_id',$id)->get();
        if($fazaa){
            return response()->json([
                "code"=>200,'status' => "sucess",
                "message"=>"get all help call by user id",
                "data"=>$fazaa
             ]);
        }else{
            return response()->json([
                "code"=>200,'status' => "error",
                "message"=>"there is no help call added yet by this user",
                "data"=>[]
             ]);
        }
        
        
    }
   
}
