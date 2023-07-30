<?php

namespace App\Services;
use App\Models\Currency;

class CurrencyService
{

    // return collection
    public function queryAll( $params = [], $language = null)
    {

    }

    // return collection
    public function getAll()
    {
        return Currency::all();
    }

    // return model
    public function showDefault()
    {
        return Currency::active()->default()->first();
    }

}
