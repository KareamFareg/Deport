<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\CarBrand;
use App\Models\CarBrandInfo;
use App\Services\CarBrandService;
use App\Helpers\UtilHelper;
use Auth;

class CarBrandController extends AdminController
{
  private $carBrandServ;

    public function __construct(CarBrandService $carBrandService)
    {

        $this->carBrandServ = $carBrandService;

        $this->share([
          'page' => CarBrand::PAGE,
          'recordsCount' => CarBrand::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $language = $this->defaultLanguage;

      $data = CarBrand::with(['car_brand_info'=> function($query) use ($language) {
          $query->where('language' , $language->locale);
      }]);


      if ($request->active_status === "0" || $request->active_status === "1" ) {
        $data->where('is_active',$request->active_status);
      };

      $data = $data->get();
      $request->flash();

      return view('admin.car_brands.index',compact(['data']));

    }

    public function create()
    {
        return view('admin.car_brands.create');
    }

    public function store(Request $request)
    {

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);
      $request->merge([ 'title_general' => $title ]);


      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
      ]);

      // check title,language doublicate in info table
      $chkTitle = CarBrandInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      $carBrand = $this->carBrandServ->store( $request->all() );
      $carBrandInfo = $this->carBrandServ->storeInfo( $request->all() + ['car_brand_id' => $carBrand->id ] );

      return redirect(route('admin.carbrands.index'));


    }

    public function edit(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      }

      $data = CarBrand::with(['car_brand_info' => function($query) use($trans) {
          $query->where('language', $trans );
      }])->where('id',$request->id)->firstorfail();

      return view('admin.car_brands.edit',compact(['trans','data']));

    }

    public function update(Request $request)
    {

      $carBrandInfo = CarBrandInfo::findOrFail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
      ]);

      // check $title,language doublicate in info table
      $chkTitle = CarBrandInfo::where('title',$title)->where('language',$request->language)->where('id','!=',$request->id)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      $carBrandInfo = $this->carBrandServ->updateInfo( $request->all() , $carBrandInfo );
      $carBrand = $this->carBrandServ->update($request->all() , carBrand::find($carBrandInfo->car_brand_id));


      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      return redirect(route('admin.carbrands.index'));

    }

    public function storeTrans(Request $request)
    {

      $carBrand =  CarBrand::findorfail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
      ]);

      $checkDoublLang = CarBrandInfo::where('car_brand_id',$request->id)->where('language',$request->language)->exists();
      if ($checkDoublLang) {
        return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language') ]);
      }

      // check title,language doublicate in info table
      $chkTitle = CarBrandInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }


      $carBrand = $this->carBrandServ->update($request->all() , $carBrand);
      $carBrandInfo = $this->carBrandServ->storeInfo($request->all() + [ 'car_brand_id' => $carBrand->id ]);

      return redirect(route('admin.carbrands.index'));

    }

    public function setActive(Request $request)
    {

        $carBrand = CarBrand::where('id',$request->id)->first();
        if (! $carBrand) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $carBrand->update(['is_active' => !$carBrand->is_active ]);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }

        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();

    }

    public function destroy(Request $request)
    {

    }

}
