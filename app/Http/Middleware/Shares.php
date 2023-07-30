<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\View;
use Auth;

class Shares
{
	public function handle($request, Closure $next)
	{
		$settingService = new \App\Services\SettingService;
		$settings = $settingService->getSettingByProperties(['logo','app_title','phone_1','mail']);
		$settings['logo'] = asset('storage/app/'.$settings['logo']);
		View::share('settings', $settings );


		$notificationService = new \App\Services\NotificationService;
		View::share('userNotifications', $notificationService->getUnreadNotificationByUserId(Auth::id()) );

		$userServices = new \App\Services\UserService;
		View::share('userLikesCount', $userServices->getUserLikesCount(Auth::id()) );

		return $next($request);

	}
}
