<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

// use App\Services\LanguageService;
use App\Models\Language;
use App\Traits\ApiResponse;

class LanguageController extends Controller
{
  use ApiResponse;
  // private $languageServ;

  // public function __construct(LanguageService $languageService)
  // {
  //     $this->languageServ = $languageService;
  // }

  public function index()
  {
    return $this->responseSuccess([
      'data' =>  Language::all()
    ]);
  }

  public function show($id)
  {

  }

  public function showDefault()
  {
    $data = Language::default()->first();
    if (! $data) {
      throw new ModelNotFoundException;
    }

    return $this->responseSuccess([
      'data' => $data
    ]);
  }

  public function getActive()
  {
      $data = Language::active()->get();
      if ($data->isEmpty()) {
        throw new ModelNotFoundException;
      }

      return $this->responseSuccess([
        'data' => $data
      ]);
  }


}
