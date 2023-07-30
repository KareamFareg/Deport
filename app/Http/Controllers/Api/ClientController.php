<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\ClientService;
use App\Traits\ApiResponse;

class ClientController extends Controller
{

  use ApiResponse;
  private $clientServ;

  public function __construct(ClientService $clientService)
  {
      $this->clientServ = $clientService;
  }

  public function index()
  {

  }



}
