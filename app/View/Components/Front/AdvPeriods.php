<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;

class AdvPeriods extends Component
{
    public $currentPage;

    public function __construct($currentPage=null)
    {
        $this->currentPage = $currentPage;
    }

    public function render()
    {
        return view('components.front.adv-periods');
    }

    public function getAdvPeriods()
    {
      return \App\Models\AdvPeriod::limited()->get();
    }

}
