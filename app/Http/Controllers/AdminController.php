<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function share($data = [])
    {

        View::share('pageTitle', !empty($data['page']) ? $data['page'] . '.title' : '');
        View::share('subTitle', !empty($data['subTitle']) ? $data['subTitle'] : '');
        View::share('recordsCount', !empty($data['recordsCount']) ? 'العدد ' . ':' . $data['recordsCount'] : '');
        View::share('languages', \App\Models\Language::active()->orderBy('is_default', 'desc')->get());
        View::share('emptyImage', asset('storage/app/' . 'empty.png'));
    }

    public function defaultLanguage()
    {

        $defaultLanguage = \App\Helpers\CommonHelper::getDefultLanguage();
        if (!$defaultLanguage) {
            abort(404, __('language.not_found'));
        }
        View::share('defaultLanguage', $defaultLanguage);
        return $defaultLanguage;

    }

    public function flashAlert($flashAlerts = [])
    {
        session()->flash('flashAlerts', $flashAlerts);
    }

}
