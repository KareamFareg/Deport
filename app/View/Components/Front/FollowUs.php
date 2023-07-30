<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class FollowUs extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.follow-us');
    }

    public function getFollowUs()
    {

      $settingServ = new \App\Services\SettingService();
      return $settingServ->getSettingByProperties(['facebook','tweeter','youtube']);

    }

}
