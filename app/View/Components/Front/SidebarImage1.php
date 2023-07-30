<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class SidebarImage1 extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.sidebar-image-1');
    }

    public function getSliders()
    {

      return \App\Models\Slider::where('type','square_01')->first();

    }

}
