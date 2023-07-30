<?php

namespace App\View\Components\Admin;
use Illuminate\View\Component;

class LanguageBar extends Component
{
    public $currentView;

    public function __construct($currentView=null)
    {
        $this->currentView = $currentView;
    }

    public function render()
    {
        return view('components.admin.language-bar');
    }

    public function getLanguages()
    {
      return \App\Models\Language::active()->get();
    }

}
