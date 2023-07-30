<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\StoreType;

class StoreTypesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $locale = app()->getLocale();



        $types = StoreType::select('id',"name", "type","image")->get();
        $data = [];
        foreach ($types as $key => $value) {
            if(!isset ($value->name[$locale]) ){
                continue;
            }

            $type['id'] = $value->id;
            $type['name'] = $value->name[$locale] ;
            $type['type'] = $value->type;
            $type['image'] = $value->image;
            $data[] = $type;
        }

        return $this->responseSuccess([
            'data' => $data,
        ]);

    }
}
