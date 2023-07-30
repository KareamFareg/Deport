<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class DownloadApp extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.download-app');
    }

    public function getAppLinks()
    {

      $settingServ = new \App\Services\SettingService();
      return $settingServ->getSettingByProperties(['app_android_lnk','app_ios_link']);

    }

}
