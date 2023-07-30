<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\View;

class AdminShares
{

	public function handle($request, Closure $next)
	{
	    $settings =  \App\Models\Setting::find(1);
        $settings= $settings->toArray();
		$settings['logo'] = asset('storage/app/'.$settings['logo']);
		View::share('settings', $settings );

		return $next($request);
	}
}
