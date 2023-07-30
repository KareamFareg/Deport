<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\PackageType;
use App\Models\PackageTypeInfo;
use App\Services\PackageTypeService;
use App\Helpers\UtilHelper;
use Auth;

class PackageTypeController extends AdminController
{
  private $packageTypeServ;

  public function __construct(PackageTypeService $packageTypeService)
  {

      $this->packageTypeServ = $packageTypeService;

      $this->share([
        'page' => PackageType::PAGE,
        'recordsCount' => PackageType::count(),
      ]);

      $this->defaultLanguage = $this->defaultLanguage();

  }

    public function index(Request $request)
    {

      $language = $this->defaultLanguage;

      $data = PackageType::with(['package_type_info'=> function($query) use ($language) {
          $query->where('language' , $language->locale);
      }]);

      if ($request->active_status === "0" || $request->active_status === "1" ) {
        $data->where('is_active',$request->active_status);
      };

      $data = $data->get();
      $request->flash();

      return view('admin.package_types.index',compact(['data']));

    }

    public function create()
    {
        return view('admin.package_types.create');
    }

    public function store(Request $request)
    {

        $title = UtilHelper::formatNormal($request->title);
        $request->merge([ 'title' => $title ]);
        $request->merge([ 'title_general' => $title ]);

        $validate = $request->validate([
            'language' =>  'required|string|exists:languages,locale',
            'title' => 'required|string|max:40',
            'price' => 'required|numeric',
        ]);

        // check title,language doublicate in info table
        $chkTitle = PackageTypeInfo::where('title',$request->title)->where('language',$request->language)->exists();
        if ($chkTitle) {
          return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
        }

        $packageType = $this->packageTypeServ->store( $request->all() );
        $packageTypeInfo = $this->packageTypeServ->storeInfo( array_merge(
          $request->all() , ['package_type_id' => $packageType->id ]
          )
        );

        return redirect(route('admin.package_types.index'));


    }

    public function edit(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      }


      $data = PackageType::with(['package_type_info' => function($query) use($trans) {
          $query->where('language', $trans );
      }])->where('id',$request->id)->firstorfail();

      return view('admin.package_types.edit',compact(['trans','data']));

    }

    public function update(Request $request)
    {

      $packageTypeInfo = PackageTypeInfo::findOrFail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
        'language' =>  'required|string|exists:languages,locale',
        'title' => 'required|string|max:40',
        'price' => 'required|numeric',
      ]);

      // check $title,language doublicate in info table
      $chkTitle = PackageTypeInfo::where('title',$title)->where('language',$request->language)->where('id','!=',$request->id)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      $packageTypeInfo = $this->packageTypeServ->updateInfo( $request->all() , $packageTypeInfo );
      $packageType = $this->packageTypeServ->update($request->all() , PackageType::find($packageTypeInfo->package_type_id));


      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      return redirect(route('admin.packagetypes.index'));

    }

    public function storeTrans(Request $request)
    {

      $packageType =  PackageType::findOrFail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:40',
          'price' => 'required|numeric',
      ]);

      $checkDoublLang = PackageTypeInfo::where('package_type_id',$request->id)->where('language',$request->language)->exists();
      if ($checkDoublLang) {
        return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language') ]);
      }

      // check title,language doublicate in info table
      $chkTitle = PackageTypeInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }


      $packageType = $this->packageTypeServ->update($request->all() , $packageType);
      $packageTypeInfo = $this->packageTypeServ->storeInfo($request->all() + [ 'package_type_id' => $packageType->id ]);

      return redirect(route('admin.packagetypes.index'));

    }

    public function setActive(Request $request)
    {

      $packageType = PackageType::where('id',$request->id)->first();
      if (! $packageType) {
        if ($request->ajax()) {
          return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
        }
        $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
        return back();
      }


      $packageType->update(['is_active' => !$packageType->is_active ]);
      if ($request->ajax()) {
        return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
      }

      $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
      return back();

    }

}
