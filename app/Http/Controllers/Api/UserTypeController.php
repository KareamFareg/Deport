<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\UserTypeService;
use App\Traits\ApiResponse;

class UserTypeController extends Controller
{
  use ApiResponse;
  private $userTypeServ;

  public function __construct(UserTypeService $userTypeService)
  {
      $this->userTypeServ = $userTypeService;
  }

  public function index()
  {
      return $this->responseSuccess( ['data' =>  $this->userTypeServ->getAll() ] );
  }


}
