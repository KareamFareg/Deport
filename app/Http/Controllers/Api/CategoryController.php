<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
use App\Models\CategoryInfo;

class CategoryController extends Controller
{

    use ApiResponse;
    private $categoryServ;
    private $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryServ = $categoryService;
        $this->productService = $productService;

    }

    public function index()
    {
        return $this->responseSuccess([
            'data' => $this->categoryServ->queryParents([1, 2, 3, 4, 5, 6, 7, 8,9]),
        ]);
    }

    public function getServices()
    {
        return $this->responseSuccess([
            'data' => $this->categoryServ->getServicesTree(),
        ]);
    }

    // public function indexForUserType($type_id)
    // {
    //     $data = $this->categoryServ->getCategoriesForUserType($type_id);
    //     if (empty($data)) {
    //       throw new ModelNotFoundException;
    //     }
    //
    //     return $this->responseSuccess([
    //       'data' => $data
    //     ]);
    // }

    public function show($id)
    {
        $data = $this->categoryServ->getCategoryById($id);
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function showWithChilds($id)
    {
        $data = $this->categoryServ->getCategoryByIdWithChilds($id);
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function showIds($ids)
    {
        $data = $this->categoryServ->getCategoryByIds(explode(',', $ids));
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function getRootCategories()
    {
        $data = $this->categoryServ->getRootCategories();
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function getDeliveryCharges($id = null)
    {

        $data = $this->categoryServ->getDeliveryCharges($id);
        // if ($data) {
        //   throw new ModelNotFoundException;
        // }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    }

    public function getCategoryClients($id = null)
    {
        $data = $this->categoryServ->getCategoryClients($id);

        if (!$data) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data->all(),
            'paginate' => [
                'total' => $data->total(),
                'lastPage' => $data->lastPage(),
                'currentPage' => $data->currentPage(),
            ],
        ], 206);

    }

    public function allItems($id)
    {
        $childIds = $this->categoryServ->getChildrenIds($id);
        $data = $this->productService->getByCategoryIds(explode(',', $childIds));
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function childItems($id)
    {
        $data = $this->productService->getByCategoryIds([$id]);
        if ($data->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);
    }

    public function store_types()
    {

        $ids=Category::where(['parent_id'=>9,'is_active'=>1])->pluck('id');
        $data = $this->categoryServ->getCategoryByIds($ids);


        return $this->responseSuccess([
            'data' => $data,
        ]);
    }
    public function cate_types($type)
    {
        // $category =[];
        $language = $language ?? app()->getLocale();
        $ids=Category::where(['parent_id'=>$type,'is_active'=>1])->pluck('id');
        foreach ($ids as $id) {
            // $cat = Category::find($id);
           $category[] =  CategoryInfo::with('category')->where('category_id' ,$id)->where('language', $language)->get();
        //    $category['type'] = $cat->type;
        }
        // $data = $this->categoryServ->getCategoryByIds($ids);
  

        return $this->responseSuccess([
            'data' => $category,
        ]);
    }


}
