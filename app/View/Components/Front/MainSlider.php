<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class MainSlider extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.main-slider');
    }

    public function getSliders()
    {

      return \App\Models\Slider::limit(3)->get();

    }

}
