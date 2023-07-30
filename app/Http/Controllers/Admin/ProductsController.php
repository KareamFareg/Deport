<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class ProductsController extends AdminController
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

    public function index(Request $request)
    {

        $categoriesIds = Category::whereIn('parent_id', [0])->get()->pluck('id');
        $categories = $this->categoryServ->queryParents($categoriesIds);
        $parents = $this->categoryServ->queryParents([6]);
        $data = Product::where('offer_id',0)->get();
        return view('admin.products.index', compact(['data', 'categories','parents']));

    }

    public function offer(Request $request)
    {

        $categoriesIds = Category::whereIn('parent_id', [0])->get()->pluck('id');
        $categories = $this->categoryServ->queryParents($categoriesIds);
        $parents = $this->categoryServ->queryParents([0]);
        $data = Product::where('is_offer',1)->get();
        return view('admin.products.index', compact(['data', 'categories','parents']));

    }

    public function getChild(Request $request)
    {
        $id = $request->id;
        $categoriesIds = Category::whereIn('parent_id', [$id])->get()->pluck('id');
        $childs = $this->categoryServ->queryParents($categoriesIds);
 
        $data='';
        foreach($childs as $child){
          $data.='<option value="'.$child->id.'">'.$child->title.'</option>';
          
        }

        return $data;
    }


     public function childData($id)
    {
       return $this->categoryServ->queryParents($id);
    }

    public function create(Request $request)
    {

        $request->validate([
            'title' => 'required|max:100',
            'category_id' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $Product = Product::create($request->all());

        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => Product::FILE_FOLDER,
                'recordId' => $Product->id,
            ]);
            $Product->Update(['image' => $path]);
        }

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();
    }

    public function delete(Request $request)
    {

        if (Product::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'category_id' => 'required',
            'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $Product = Product::find($request->route('id'));
        if ($Product) {

            $Product->title = $request['title'];
            $Product->category_id = $request['category_id'];

            // $request->merge(['title' => array_merge($Product->title, $request->title)]);
            // $Product->title = $request['title'];
            // $request->merge(['description' => array_merge($Product->description, $request->description)]);
            // $Product->description = $request['description'];

            $Product->save();

            if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'image',
                    'folder' => Product::FILE_FOLDER,
                    'recordId' => $Product->id,
                ]);
                $Product->Update(['image' => $path]);
            }

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

}
