<?php

namespace App\Services;
use App\Models\UserCategory;

class UserCategoryService
{

    public function storeMany($request,$userId)
    {
        UserCategory::where('user_id',$userId)->delete();

        // valiadte to get only categories found in categories table
        $machCategories = \App\Models\Category::wherein('id',$request['categories'])->pluck('id')->toArray();

        foreach ($machCategories as $category) {
          UserCategory::create( ['user_id' => $userId , 'category_id' => $category]);
        }

        return true;
    }



}
