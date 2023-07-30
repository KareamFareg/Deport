<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Services\CategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use App\Models\Market;
use App\Traits\saveImage;
use Illuminate\Support\Facades\Validator;

class MktnController extends AdminController
{
use saveImage;
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

    
    public function index(Request $request)
    {
        $markets= Market::all();

        return view('admin.mktn.index',['markets'=>$markets]);

    }
    public function getShopsBySouqId($local ,$id){
        $shops = Shop::where('souq_id' ,$id)->get();
 
       return view('admin.shops.index',['shops' => $shops]);
   }
    public function getById($local ,$id){
        $market = Market::findOrFail($id);
       return view('admin.mktn.edit',['market' => $market]);
   }


public function add(){
    $language = $language ?? app()->getLocale();
    return view('admin.mktn.create',['language'=>$language]);
}
public function create(Request $request)
{
 
    $rules = [
        'name'=>'required',
        'city'=>'required',
        'icon'=>'required|file|image|mimes:jpeg,png,gif,jpg|max:1024'
    ];
    $validation = Validator::make($request->all() ,  $rules);
    if ($validation->fails()){
        return redirect()->back()->withErrors($validation)->withInputs($request->all());
    }
    $market = Market::create($request->all());
        // $market = new Market();
        // $market->name    = $request->name;
        // $market->city    = $request->city;
                  
        //  $market->save();
         if ($request->hasFile('icon')) {
            $path = $this->storeFile($request, [
                'fileUpload' =>'icon',
                'folder' => Market::FILE_FOLDER,
                'recordId' => $market->id,
            ]);
            $market->Update(['icon' => $path]);
        }
        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();
       
}

public function edit($local , $id){
    $market = Market::find($id);
    if($market == null){
        return view('welcome');
    }
    return view('admin.mktn.edit',['market' => $market]);

}


public function update(Request $request,$local, $id){
 
    $rules = [
        'name'=>'string',
        'city'=>'string'
    ];
    $validation = Validator::make($request->all() ,  $rules);
    if ($validation->fails()){
        return redirect()->back()->withErrors($validation)->withInputs($request->all());
    }else
    {
        $market =  Market::find($id);
        if(isset($request->name)){$market->name = $request->name;}    
        if(isset($request->city)){$market->city    = $request->city;}
        $market->save();
        if ($request->hasFile('icon')) {
            $path = $this->storeFile($request, [
                'fileUpload' =>'icon',
                'folder' => Market::FILE_FOLDER,
                'recordId' => $market->id,
            ]);
            
        }else{
            $path = $market->icon ;
        }
        $market->Update(['icon' => $path]);
        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        $request->flash();
        return back();
 
        
    }
}

public function remove($local ,$id){
     $market = Market::find($id);
     $Result = $market->delete();
     if($Result){
        $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
        return back();
    }else{
        $this->flashAlert(['success' => ['msg' => __('messages.deleted_faild')]]);
        return back();
    }
}
}
