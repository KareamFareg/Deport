<?php

namespace App\Http\Controllers\Admin;
use App\Models\Market;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\saveImage;
use App\Models\Setting;



use App\Helpers\UtilHelper;
use App\Http\Controllers\AdminController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryInfo;
use App\Services\CategoryService;
use App\Traits\FileUpload;
// use Illuminate\Http\Request;


class MarketController extends Controller
{
    use FileUpload;
    private $categoryService;
    private $defaultLanguage;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, saveImage;
public function testing(){
     // get just product categories admin cant create services just create pruduct categories
     $categories = $this->categoryService->queryParents([1, 2, 3]);
     $temp = [];
     $parents = UtilHelper::buildTreeRoot($categories, null, $temp, 0, 0);
     return view('markets.testing', compact(['parents']));

}
    public function getAll(){
        $markets= Market::all();
        // $temp = [];
        // $data = UtilHelper::buildTreeRoot($markets, null, $temp, 0, 0);
    //    var_dump($markets);
        return view('admin.markets.index',['markets'=>$markets]);
    }

    public function getById($id){
         $market = Market::findOrFail($id);
        return view('admin.markets.edit',['market' => $market]);
    }
    public function add(){
        $language = $language ?? app()->getLocale();
        return view('admin.markets.create',['language'=>$language]);
    }
    public function create(Request $request)
    {
     
        $rules = [
            'name'=>'required',
            'icon'=>'required',
            
        ];
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            $market = new Market();
            $market->name    = $request->name;
                      
             $market->save();
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'icon',
                    'folder' => Market::FILE_FOLDER,
                    'recordId' => $market->id,
                ]);
            }
                $market->icon = $path;
                $Result = $market->save();  
            if($Result==1)
            {
                return 'تم الحفظ بنجاح';

            }
            else
            {
                return'هناك خطأ';

            }
return redirect(route('markets.getAll'));
        }
    }

    public function edit($id){
        $market = Market::find($id);
        if($market == null){
            return view('welcome');
        }
        return view('admin.markets.edit',['market' => $market]);
    }


    public function update($id , Request $request){
     
        $rules = [
            'name'=>'required|string',
            
        ];
        $validation = Validator::make($request->all() ,  $rules);
        if ($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInputs($request->all());
        }else
        {
            $market =  Market::find($id);
            $market->name    = $request->name;
            if ($request->hasFile('icon')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'icon',
                    'folder' => Market::FILE_FOLDER,
                    'recordId' => $market->id,
                ]);
            }
                $market->icon = $path;
            $Result = $market->save();

            if($Result==1)
            {
                return 'تم الحفظ بنجاح';

            }
            else
            {
                return'هناك خطأ';

            } 
        }
    }

    public function remove($id){
         $market = Market::find($id);
         $Result = $market->delete();
        if($Result==1)
        {
            return 'deleted succ';

        }
        else
        {
          return'هناك خطأ';

        } 
    }

}
