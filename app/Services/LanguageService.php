<?php

namespace App\Services;
use App\Models\Language;

class LanguageService
{

  public function getAll()
  {
    return Language::all();
  }

}
