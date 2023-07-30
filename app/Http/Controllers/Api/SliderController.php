<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Slider;
use App\Traits\ApiResponse;

class SliderController extends Controller
{

  use ApiResponse;

  public function index()
  {
      return $this->responseSuccess([
        'data' => Slider::all()
      ]);
  }



}
