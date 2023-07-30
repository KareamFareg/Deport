<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LanguageController extends Controller
{

    public function index()
    {
        return view('admin.languages.index');
    }


}
