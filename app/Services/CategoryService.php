<?php

namespace App\Services;

use App\Helpers\UtilHelper;
use App\Models\Category;
use App\Models\CategoryInfo;
use App\Traits\Cachement;
use Illuminate\Support\Facades\DB;
use Auth;
class CategoryService
{
    use Cachement;

    // return collection
    public function queryAll($params = [], $language = null)
    {
        $language = $language ?? app()->getLocale();

        $data = DB::Table('categories')
            ->leftjoin("category_info", function ($join) use ($language) {
                $join->on('categories.id', '=', 'category_info.category_id')->where('category_info.language', $language);
            })
            ->where('categories.is_default', '=', 0)
            //->whereNotIn('categories.id',[1,4,5,6,7,8])
            ->select('categories.id', 'categories.title_general', 'categories.parent_id', 'category_info.title', 'category_info.alias', 'category_info.image',
                'type', 'is_active')
            ->orderby('categories.sort')->orderby('categories.id')->get();

        return $data;
    }

    public static function queryParents($ids = [], $language = null)
    {
        $language = $language ?? app()->getLocale();

        $data = DB::Table('categories')
            ->leftjoin("category_info", function ($join) use ($language) {
                $join->on('categories.id', '=', 'category_info.category_id')->where('category_info.language', $language);
            })
            ->where('categories.is_default', '=', 0)
            ->whereIn('categories.id',$ids)
            
            ->select('categories.id', 'categories.title_general', 'categories.parent_id', 'category_info.title', 'category_info.alias', 'category_info.image',
                'type', 'is_active')
            ->orderby('categories.sort')->orderby('categories.id')->get();

        return $data;
    }

    // return collection
    public function getAll($language = null)
    {
        $this->cacheFlush();

        $language = $language ?? app()->getLocale();
        $cacheName = 'categories' . '-' . $language;

        // if ($this->cacheHas($cacheName)) {
        //     return $this->cacheGet($cacheName);
        // }

        $data = $this->queryAll([], $language);
        $this->cacheForever($cacheName, $data);

        return $data;

    }

    // return Array services and categories as tree
    public function getCategoriesTree($language = null)
    {

        // $this->cacheFlush();

        $language = $language ?? app()->getLocale();
        // $cacheName = 'categories-tree'.'-'.$language ;
        //
        // if ( $this->cacheHas($cacheName) ) {
        //   return $this->cacheGet($cacheName);
        // }

        $data = $this->getAll($language)->filter(function ($category) {
            if ($category->type == 'service' || $category->type == 'category') {
                return $category;
            }
        });

        $data = UtilHelper::buildTree($data);
        // $this->cacheForever($cacheName,$data);

        return $data;
    }

    // return Array services as tree
    public function getServicesTree($language = null)
    {

        // $this->cacheFlush();

        $language = $language ?? app()->getLocale();
        // $cacheName = 'services-tree'.'-'.$language ;

        // if ( $this->cacheHas($cacheName) ) {
        //   return $this->cacheGet($cacheName);
        // }

        $data = $this->getAll($language)->filter(function ($category) {
            return $category->type == 'service';
        });

        $data = UtilHelper::buildTree($data);
        // $this->cacheForever($cacheName,$data);

        return $data;
    }

    // return collection
    public function getRootCategories($language = null)
    {
        $data = $this->getAll($language)->filter(function ($category) {
            return $category->parent_id == 0;
        });
        return $data->values();
    }

    // return array
    // public function getCategoriesForUserType($typeId , $language = null)
    // {
    //
    //     $language = $language ?? app()->getLocale();
    //     $cacheName = 'categories-tree'.'-'.$typeId.'-'.$language ;
    //
    //     if ( $this->cacheHas($cacheName) ) {
    //       return $this->cacheGet($cacheName);
    //     }
    //
    //     $data = $this->getAll()->filter(function ($category) use ($typeId) {
    //         return $category->user_type_id == $typeId ;
    //     });
    //
    //     $data = UtilHelper::buildTree( $data );
    //     $this->cacheForever($cacheName,$data);
    //
    //     return $data;
    // }

    // return collection
    public function getCategoryById($id, $language = null)
    {
        $data = $this->getAll($language)->where('id', $id);
        return $data->values();
    }

    // return array on category with childs
    public function getCategoryByIdWithChilds($id, $language = null)
    {

        $categories = $this->getAll($language);

        $current = $categories->where('id', $id);
        $current = $current->values();
        if ($current->isEmpty()) {
            return $current;
        }

        $data = UtilHelper::buildTree($categories, $id);

        $current[0]->children = $data;

        // if we return $current it's array and we dont need array here just the item and it's childs
        // so we will get [0] of the array which is std class . and convert std class to collection by collect
        return collect($current[0]);

    }

    // return collection
    public function getCategoryByIds($ids, $language = null)
    {
        $data = $this->getAll()->wherein('id', $ids);
        return $data->values();
    }

    public function getChildrenIds($id)
    {

        $current = $this->getCategoryByIdWithChilds($id);
        $childrenIds = $id;
        if (!$current->isEmpty()) {
            if (isset($current['children'])) {
                foreach ($current['children'] as $value) {
                    $childrenIds = $childrenIds . ',' . $value->id;
                    if (isset($value->children)) {
                        foreach ($value->children as $value2) {
                            $childrenIds = $childrenIds . ',' . $value2->id;
                        }
                    }
                }
            }
        }

        return $childrenIds;

    }

    public function getDeliveryCharges($id = null)
    {
        if ($id) {
            return Category::with('deliveryCharges')->where('id', $id)->first();
        }
        return Category::with('deliveryCharges')->get();
    }

    public function getCategoryClients($id = null, $language = null)
    {
        // return Category::with('users.client.translation')->where('id',$id)->first();

        $language = $language ?? app()->getLocale();

        $data = DB::Table('categories')
            ->join('user_category', 'categories.id', '=', 'user_category.category_id')
            ->join('users', 'users.id', '=', 'user_category.user_id')
            ->join('clients', 'users.id', '=', 'clients.user_id')
            ->join('client_info', 'clients.id', '=', 'client_info.client_id')
            ->when($id, function ($query, $id) {
                return $query->where('categories.id', '=', $id);
            })
            ->where('categories.is_active', '=', 1)
            ->where('users.is_active', '=', 1)
            ->where('users.is_active_admin', '=', 1)
            ->where('users.is_verified', '=', 1)
            ->where('client_info.language', '=', $language)
            ->select('users.id', 'clients.id as client_id', 'client_info.title', 'users.rate', 'users.rate_count', 'client_info.logo', 'client_info.banner', 'client_info.description', 'users.lat', 'users.lng', 'client_info.viewed')
            ->distinct('clients.id')
            ->paginate(2);
        return $data;

    }

    public function getCategoryClientsFormat($data)
    {

        // if ( empty($data->users) ) {
        //   return [];
        // }
        //
        // $newData = [];
        // $newUser = [];
        // foreach ($data->users as $user) {
        //       $newUser = $newUser + ['id' => $user->id];
        //       $newUser = $newUser + ['rate' => $user->rate];
        //       $newUser = $newUser + ['rate_count' => $user->rate_count];
        //       $newUser = $newUser + ['lat' => $user->lat];
        //       $newUser = $newUser + ['lng' => $user->lng];
        //
        //       if ($user->client) {
        //           $newUser = $newUser + ['client_id' => $user->client->id];
        //           $newUser = $newUser + ['logo' => $user->client->logo];
        //           $newUser = $newUser + ['banner' => $user->client->banner];
        //
        //           if (! $user->client->translation->isEmpty()) {
        //               foreach ($user->client->translation as $translation) {
        //                 $newUser = $newUser + ['description' => $translation['description']];
        //                 $newUser = $newUser + ['title' => $translation['title']];
        //               }
        //           }
        //       }
        //     $newData[] = $newUser;
        // }
        //
        // return $newData;

    }

    public function setActive($category, $status)
    {

        $category->update(['is_active' => $status]);

        $childs = Category::where('parent_id', $category->id)->get();

        foreach ($childs as $child) {
            $this->setActive($child, $status);
        }

        $this->cacheClearGroup('categories');

    }

    public function storeCategory($request)
    {

        $category = new Category();
        $category->title_general = $request['title'];
        $category->type = 'category';
        $category->parent_id = $request['parents'];
        $category->sort = $request['sort'];
        $category->is_active = $request['is_active'];
        $category->save();

        return $category;
    }

    public function storeCategoryInfo($request)
    {

        $categoryInfo = new CategoryInfo();
        $categoryInfo->category_id = $request['category_id'];
        $categoryInfo->language = $request['language'];
        $categoryInfo->title = $request['title'];
        $categoryInfo->alias = $request['alias'];
        $categoryInfo->description = $request['description'];
        $categoryInfo->meta_description = $request['title'];
        $categoryInfo->meta_keywords = $request['title'];
        $categoryInfo->template_id = 1;
        $categoryInfo->ip = UtilHelper::getUserIp();
        $categoryInfo->access_user_id = Auth::id();
        $categoryInfo->save();

        $this->cacheClearGroup('categories');

        return $categoryInfo;

    }

    public function updateCategory($request, $category)
    {

        // if current category is service don't update parent_id keep it in it's place
        if ($category->type == 'category') {
            $category->parent_id = $request['parents'] ; //== 0 ? 1 : $request['parents'];
        }
       $category->sort = $request['sort'];
        $category->save();

        $this->cacheClearGroup('categories');

        return $category;

    }

    public function updateCategoryInfo($request, $categoryInfo)
    {

        $categoryInfo->title = $request['title'];
        $categoryInfo->alias = $request['alias'];
        $categoryInfo->description = $request['description'];
        $categoryInfo->meta_description = $request['title'];
        $categoryInfo->meta_keywords = $request['title'];
        $categoryInfo->template_id = 1;
        $categoryInfo->ip = UtilHelper::getUserIp();
        $categoryInfo->access_user_id = Auth::id();
        $categoryInfo->save();

        return $categoryInfo;

    }

}
