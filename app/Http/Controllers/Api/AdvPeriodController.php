<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdvPeriod;
use App\Traits\ApiResponse;

class AdvPeriodController extends Controller
{

    use ApiResponse;

    public function index()
    {
        return $this->responseSuccess([
            'data' => AdvPeriod::limited()->get(),
        ]);
    }

}
