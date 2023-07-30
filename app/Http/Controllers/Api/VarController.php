<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Years;
use App\Traits\ApiResponse;

class VarController extends Controller
{

  use ApiResponse;

  public function getYears()
  {
      return $this->responseSuccess([
        'data' =>  Years::all()
      ]);
  }

  public function show($id)
  {

  }



}
