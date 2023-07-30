<?php

namespace App\Services;

use App\Helpers\UtilHelper;
use App\Models\Product;
use App\Traits\Cachement;
use Illuminate\Support\Facades\DB;


class ProductService{


    public function getAll($language=null){

        //$language = $language ?? app()->getLocale();
        return Product::get();
    }

    public function getByCategoryIds($ids=[],$language=null){

        $language = $language ?? app()->getLocale();
        return Product::whereIn('category_id',$ids)->where('offer_id',0)->get();
    }


}
