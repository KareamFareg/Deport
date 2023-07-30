<?php

namespace App\Traits;

trait WebTrait
{
  public function flashAlert( $flashAlerts = [] )
	{
		session()->flash('flashAlerts',$flashAlerts);
	}
}
