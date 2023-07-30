<?php

namespace App\View\Components\Front;
use Illuminate\View\Component;
use App\Helpers\UtilHelper;

class TheMost extends Component
{
    public $currentMost;

    public function __construct($currentMost=null)
    {
        $this->currentMost = $currentMost;
    }

    public function render()
    {
        return view('components.front.the-most');
    }

    public function getTheMost()
    {

      return \App\Models\Item::with(['user.client.client_info','item_type','item_info' => function($query) {
        $query->where('language',app()->getLocale());
      }])
      ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
      ->orderBy( $this->currentMost ,'desc')->limit(6)->get();

    }

}
