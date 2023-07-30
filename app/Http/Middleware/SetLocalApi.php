<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Language;
use App\Helpers\CommonHelper;
use App\Traits\ApiResponse;

class SetLocalApi
{
	use ApiResponse;

	public function handle($request, Closure $next)
	{
		$locale = $request->header('Content-Language');

		if (! $locale)
		{
			// get default Language
			$defaultLocale = CommonHelper::getDefultLanguage();
			if (! $defaultLocale) {
				$response = [ 'errors' => [ 'اللغة - Language' => ['message'=> 'Not Found - غير موجودة'] ] ];
				return $this->responseFaild($response);
			}
			app()->setLocale($defaultLocale->locale);
		} else {
			// search language
			$locale = Language::where('locale', strip_tags($locale))->active()->first();
			if ( $locale ) {
				// if found
				app()->setLocale($locale->locale);
			} else {
				// if not founded get default language
				$defaultLocale = CommonHelper::getDefultLanguage();
				if (! $defaultLocale) {
					$response = [ 'errors' => [ 'اللغة - Language' => ['message'=> 'Not Found - غير موجودة'] ] ];
					return $this->responseFaild($response);
				}
				app()->setLocale($defaultLocale->locale);
			}
		}

		return $next($request);

	}
}
