<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class OuterStatments extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.outer-statments');
    }

    public function getStatments()
    {

      $settingServ = new \App\Services\SettingService();
      return $settingServ->getSettingByProperties(['register_st_1','register_st_2','register_st_3']);

    }

}
