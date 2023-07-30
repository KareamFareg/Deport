<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use CommonHelper;
use Illuminate\Support\Facades\URL;

class SetLocal
{

    public function handle($request, Closure $next)
    {

        if (!$request->locale) {
            // get default Language
            $defaultLocale = CommonHelper::getDefultLanguage();
            if (!$defaultLocale) {
                abort(404, __('language.not_found'));
            }
            app()->setLocale($defaultLocale->locale);
            URL::defaults(['locale' => $defaultLocale->locale]);
            $request->session()->flash('locale', $defaultLocale);
            return redirect(route(request()->route()->getName()));
        } else {
            // search language
            //$locale = Language::where('locale', strip_tags($request->locale))->active()->first();
            $locale = Language::where('locale', strip_tags('ar'))->active()->first();
            if ($locale) {
                // if found
                app()->setLocale($locale->locale);
                URL::defaults(['locale' => $locale->locale]);
                $request->session()->flash('locale', $locale);
               if($request->locale != 'ar'){
                return redirect(route(request()->route()->getName()));
               }

            } else {
                // if not founded get default language
                $defaultLocale = CommonHelper::getDefultLanguage();
                if (!$defaultLocale) {
                    abort(404, __('language.not_found'));
                }
                app()->setLocale($defaultLocale->locale);
                URL::defaults(['locale' => $defaultLocale->locale]);
                $request->session()->flash('locale', $defaultLocale);
                if ($request->locale == 'login') { // to dont show message (unauthorized) at the biginng
                    return redirect(route('admin.login'));
                }
                return redirect(route(request()->route()->getName()));
            }
        }
        return $next($request);

    }
}
