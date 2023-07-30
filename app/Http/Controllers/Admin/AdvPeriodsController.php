<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\AdvPeriod;
use App\Helpers\UtilHelper;
use Auth;

class AdvPeriodsController extends AdminController
{

    public function __construct()
    {

        $this->share([
          'page' => AdvPeriod::PAGE,
          'recordsCount' => AdvPeriod::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $trans = $this->defaultLanguage;
      $data = AdvPeriod::limited()->get();

      $request->flash();

      return view('admin.adv_periods.index',compact(['data','trans']));

    }

    public function store(Request $request)
    {

      $request->flash();

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
          // 'language' =>  'required|string|exists:languages,locale',
          'title' => 'required|string|max:50|unique:adv_periods,title,',
          'period' => 'required|integer|unique:adv_periods,period',
      ]);


      if (! AdvPeriod::create($request->all()) ) {
        return back()->withErrors(['error' , __('messages.added_faild')])->withinput();
      }

      $this->flashAlert([
        'success' => ['msg'=> __('messages.added') ]
      ]);

      return redirect(route('admin.adv_periods.index'));

    }


    public function update(Request $request)
    {

      $request->flash();

      $advPeriod = AdvPeriod::findorfail($request->id);

      $title = UtilHelper::formatNormal($request->title);
      $request->merge([ 'title' => $title ]);

      $validate = $request->validate([
        // 'language' =>  'required|string|exists:languages,locale',
        'title' => 'required|string|max:50|unique:adv_periods,title,'.$request->id,
        'period' => 'required|integer|unique:adv_periods,period,'.$request->id,
      ] , [] , [ 'period' => __('adv_periods.name') ] );


      if (! $advPeriod->update( [ 'title' => $request->title , 'period' => $request->period ] ) ) {
        return back()->withErrors(['error' , __('messages.updated_faild')])->withinput();
      }

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      return redirect(route('admin.adv_periods.index'));

    }


    public function setActive(Request $request)
    {

        // $carType = CarType::where('id',$request->id)->first();
        // if (! $carType) {
        //   if ($request->ajax()) {
        //     return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
        //   }
        //   $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
        //   return back();
        // }
        //
        //
        // $carType->update(['is_active' => !$carType->is_active ]);
        // if ($request->ajax()) {
        //   return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        // }
        //
        // $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        // return back();

    }



}
