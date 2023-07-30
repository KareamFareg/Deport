<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\CarType;
use App\Models\CarTypeInfo;
use App\Services\CarTypeService;
use App\Helpers\UtilHelper;
use Auth;

class CarTypeController extends AdminController
{
  private $carTypeServ;

    public function __construct(CarTypeService $carTypeService)
    {

        $this->carTypeServ = $carTypeService;

        $this->share([
          'page' => CarType::PAGE,
          'recordsCount' => CarType::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $language = $this->defaultLanguage;
  

      $data = CarType::with(['car_type_info'=> function($query) use ($language) {
          $query->where('language' , $language->locale);
      }]);

      if ($request->active_status === "0" || $request->active_status === "1" ) {
        $data->where('is_active',$request->active_status);
      };

      $data = $data->get();
      $request->flash();

      return view('admin.car_types.index',compact(['data']));

    }

    public function create()
    {
        return view('admin.car_types.create');
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
      $chkTitle = CarTypeInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      $carType = $this->carTypeServ->store( $request->all() );
      $carTypeInfo = $this->carTypeServ->storeInfo( $request->all() + ['car_type_id' => $carType->id ] );

      return redirect(route('admin.cartypes.index'));


    }

    public function edit(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      }


      $data = CarType::with(['car_type_info' => function($query) use($trans) {
          $query->where('language', $trans );
      }])->where('id',$request->id)->firstorfail();

      return view('admin.car_types.edit',compact(['trans','data']));

    }

    public function update(Request $request)
    {

      $carTypeInfo = CarTypeInfo::findOrFail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
      ]);

      // check $title,language doublicate in info table
      $chkTitle = CarTypeInfo::where('title',$title)->where('language',$request->language)->where('id','!=',$request->id)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      $carTypeInfo = $this->carTypeServ->updateInfo( $request->all() , $carTypeInfo );
      $carType = $this->carTypeServ->update($request->all() , carType::find($carTypeInfo->car_type_id));


      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      return redirect(route('admin.cartypes.index'));

    }

    public function storeTrans(Request $request)
    {

      $carType =  CarType::findOrFail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
      ]);

      $checkDoublLang = CarTypeInfo::where('car_type_id',$request->id)->where('language',$request->language)->exists();
      if ($checkDoublLang) {
        return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language') ]);
      }

      // check title,language doublicate in info table
      $chkTitle = CarTypeInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }


      $carType = $this->carTypeServ->update($request->all() , $carType);
      $carTypeInfo = $this->carTypeServ->storeInfo($request->all() + [ 'car_type_id' => $carType->id ]);

      return redirect(route('admin.cartypes.index'));

    }

    public function setActive(Request $request)
    {

        $carType = CarType::where('id',$request->id)->first();
        if (! $carType) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $carType->update(['is_active' => !$carType->is_active ]);
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
