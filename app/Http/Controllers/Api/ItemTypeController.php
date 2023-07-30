<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\ItemType;
use App\Traits\ApiResponse;

class ItemTypeController extends Controller
{

  use ApiResponse;

  public function index()
  {
      return $this->responseSuccess([
        'data' => ItemType::all()
      ]);
  }



}
