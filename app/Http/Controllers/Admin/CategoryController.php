<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UtilHelper;
use App\Http\Controllers\AdminController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryInfo;
use App\Services\CategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CategoryController extends AdminController
{
    use FileUpload;
    private $categoryServ;
    private $defaultLanguage;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServ = $categoryService;

        $this->share([
            'page' => Category::PAGE,
            'recordsCount' => Category::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {
        $trans = null;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $categories = $this->categoryServ->getAll($trans);
        $temp = [];
        $categories = UtilHelper::buildTreeRoot($categories, null, $temp, 0, 0);
        //   dump($categories);
        return view('admin.categories.index', compact(['categories', 'trans']));
    }

    public function create()
    {

        // get just product categories admin cant create services just create pruduct categories
        // $categories = $this->categoryServ->queryParents([1, 2, 3]);
        $categories = Category::where('id' ,'>' , 0)->get()->pluck('id');
        $categories = $this->categoryServ->queryParents($categories);
        $temp = [];
        $parents = UtilHelper::buildTreeRoot($categories, null, $temp, 0, 0);
        return view('admin.categories.create', compact(['parents']));

    }

    public function store(CategoryRequest $request)
    {
        // check title,language doublicate in info table
        $chkTitle = CategoryInfo::where('title', $request['title'])->where('language', $request['language'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id', $request['parents'])->exists();
     
        if ($chkTitle) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language')]);
        }

        // check alias,language doublicate in info table
        $chkAlias = CategoryInfo::where('alias', $request['alias'])->where('language', $request['language'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id', $request['parents'])->exists();
        if ($chkAlias) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language')]);
        }

        $active = 1;
        // check if parent is category not service and if parent is inactive
        if ($request['parents'] != 0) {
            $parent = Category::where('id', $request['parents'])->select('type', 'is_active')->firstOrFail();
            // if ($parent->type != 'category'){
            //   return back()->withinput()->withErrors(['parents' => __('messages.error_data') ]);
            // }
            if ($parent->is_active == 0) {
                $active = 0;
            }
        }

        $category = $this->categoryServ->storeCategory($request->validated() + ['is_active' => $active]);
        $categoryInfo = $this->categoryServ->storeCategoryInfo($request->validated() + ['category_id' => $category->id]);

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => Category::FILE_FOLDER,
                'recordId' => $categoryInfo->id,
            ]);
            $categoryInfo->Update(['image' => $path]);
        }

        return redirect(route('admin.categories.index'));

    }

    public function edit(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $data = Category::with(['category_info' => function ($query) use ($trans) {
            $query->where('language', $trans);
        }])->where('id', $request->id)->firstorfail();

        // google categories can'e be edit
        if ($data->read_only === 1) {
            return back();
        }

        // $parents = $this->categoryServ->getCategoryByIdWithChilds(1);
        // if (!$parents->isEmpty()) {
        //   $parents = UtilHelper::treeToRoot($parents['children'],'children');
        // }

        // $categories = $this->categoryServ->queryParents([1, 2, 3]);
        $categories = Category::where('id' ,'>' , 0)->get()->pluck('id');
        $categories = $this->categoryServ->queryParents($categories);
        $temp = [];

        if ($data->parent_id == 0) {
            $parents = UtilHelper::buildTreeRoot($categories, null, $temp, 0, 0);

        } else {
            $parents = UtilHelper::buildTreeRoot($categories, $request->id, $temp, 0, 0);

        }

        return view('admin.categories.edit', compact(['parents', 'trans', 'data']));

    }

    public function update(CategoryRequest $request)
    {

        $categoryInfo = CategoryInfo::findOrFail($request->id);

        // check title,language doublicate in info table
        $chkTitle = CategoryInfo::where('title', $request['title'])->where('language', $request['language'])->where('category_info.id', '!=', $request['id'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id', Category::find($categoryInfo->category_id)->parent_id)->exists();
        if ($chkTitle) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language')]);
        }

        // check alias,language doublicate in info table
        $chkAlias = CategoryInfo::where('alias', $request['alias'])->where('language', $request['language'])->where('category_info.id', '!=', $request['id'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id', Category::find($categoryInfo->category_id)->parent_id)->exists();
        if ($chkAlias) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language')]);
        }

        $categoryInfo = $this->categoryServ->updateCategoryInfo($request->validated(), $categoryInfo);
        $category = $this->categoryServ->updateCategory($request->validated(), Category::find($categoryInfo->category_id));

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => Category::FILE_FOLDER,
                'recordId' => $categoryInfo->id,
            ]);
            $categoryInfo->Update(['image' => $path]);
        }

        return redirect(route('admin.categories.index'));

    }

    public function storeTrans(CategoryRequest $request)
    {

        $category = Category::findOrFail($request->id);

        $checkDoublLang = CategoryInfo::where('category_id', $request['id'])->where('language', $request['language'])->exists();
        if ($checkDoublLang) {
            return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language')]);
        }

        // check title,language doublicate in info table
        $chkTitle = CategoryInfo::where('title', $request['title'])->where('language', $request['language'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id',$category->parent_id)->exists();
        if ($chkTitle) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language')]);
        }

        // check alias,language doublicate in info table
        $chkAlias = CategoryInfo::where('alias', $request['alias'])->where('language', $request['language'])->join('categories', 'categories.id', '=', 'category_info.category_id')->where('parent_id',$category->parent_id)->exists();
        if ($chkAlias) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language')]);
        }

        $active = 1;
        // check if parent is category not service and if parent is inactive
        if ($request['parents'] != 0) {
            $parent = Category::where('id', $request['parents'])->select('type')->firstOrFail();
            if ($parent->is_active == 0) {
                $active = 0;
            }
        }

        $category = $this->categoryServ->updateCategory($request->validated(), $category);
        $categoryInfo = $this->categoryServ->storeCategoryInfo($request->validated() + ['category_id' => $category->id]);

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => Category::FILE_FOLDER,
                'recordId' => $categoryInfo->id,
            ]);
            $categoryInfo->Update(['image' => $path]);
        }

        return redirect(route('admin.categories.index'));

    }

    public function setActive(Request $request)
    {

        $category = Category::findOrFail($request->id);
        $status = !$category->is_active;

        // if we try to active a category so check the parent of it if the parent is inactive then make it active
        if ($status == 1) {
            $parent = Category::where(['id' => $category->parent_id, 'is_active' => 0])->first();
            if ($parent) {
                $this->flashAlert(['faild' => ['msg' => __('category.activate_parent') . ' - ' . $parent->translation->first()->title]]);
                return back();
            }
        }

        $this->categoryServ->setActive($category, $status);
        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        return back();

    }

    public function delete(Request $request)
    {

        $id = $request->route('id');
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
        $category->delete();

        return response()->json(['success' => __('messages.deleted')]);

    }

}
