<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function share( $data = [])
    {

      View::share('page',  !empty($data['page']) ? $data['page'] : ''  ) ;
      View::share('pageTitle',  !empty($data['page']) ? $data['page'].'.title' : ''  ) ;
      View::share('languages', \App\Models\Language::active()->orderBy('is_default','desc')->get());
      View::share('emptyImage', asset('storage/app/'.'empty.png') );
    }

    public function defaultLanguage()
    {

      $defaultLanguage = \App\Helpers\CommonHelper::getDefultLanguage();
      if (! $defaultLanguage) {
        abort(404, __('language.not_found'));
      }
      View::share('defaultLanguage',$defaultLanguage);
      return $defaultLanguage;

    }

    public function flashAlert( $flashAlerts = [] )
    {
      session()->flash('flashAlerts',$flashAlerts);
    }

    public static function seoInfo($type,$source)
    {

      $settingServ = new \App\Services\SettingService();
      $settings = $settingServ->getSettingByProperties(['app_title','register_st_1','register_st_2','register_st_3','logo']);

      $siteName = $settings['app_title'];
      $title = $settings['app_title'];
      $description = $settings['register_st_1'] . '-' . $settings['register_st_2'] . '-' .$settings['register_st_3']  ;
      $url = url('/');
      $image = url($settings['logo']);



        switch ($type) {
            case "item":
                $url = route('items.show',['id'=>$source->item_info->first()->item_id]);
                $image = $source->item_info->first()->imagePath();
                $title = $siteName . ' - ' . $source->item_info->first()->title;
                $description = \Illuminate\Support\Str::limit(strip_tags($source->item_info->first()->description),100);
                break;
            case "category":
                $url = route('front.category.show',['alias'=>$source->alias]);
                $image = url(\App\Category::IMAGE_PATH . $source->img );
                $title = $siteName . ' - ' . $source->title;
                $description = \Illuminate\Support\Str::limit(strip_tags($source->description),100);
                break;
            // default:
            //     $url = route('front.index');
        }




      $seoInfo = '<title>'. $title. '</title>'.
      '<meta name="keywords" content="'.$title.'">'.
      '<meta name="description" content="'.$description.'">'.
      '<meta property="og:title" content="'.$title.'"/>'.
      '<meta property="og:type" content="product"/>'.
      '<meta property="og:url" content="'.$url.'"/>'.
      '<meta property="og:image" content="'.$image.'"/>'.
      '<meta property="og:site_name" content="'.$siteName.'"/>'.
      '<meta property="og:description" content="'. $description .'"/>'.

      '<meta name="twitter:card" content="summary_large_image"/>'.
      '<meta name="twitter:site" content="'.$siteName.'"/>'.
      '<meta name="twitter:title" content="'.$title.'"/>'.
      '<meta name="twitter:description" content="'.$description.'"/>'.
      '<meta name="twitter:image" content="'.$image.'"/>';
      // dd($seoInfo);

      View::share('seo_info', $seoInfo);

    }


}
