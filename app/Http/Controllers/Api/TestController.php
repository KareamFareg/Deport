<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Years;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class TestController extends Controller
{

    use ApiResponse;

    public function getYears()
    {
        return $this->responseSuccess([
            'data' => Years::all(),
        ]);
    }

    public function show($id)
    {

    }

    public function testGetApiName(Request $request)
    {
       // return response()->json($request->description) ;
       // return response()->json([$request->route()->getName(),$request->all()]) ;
    }

}
