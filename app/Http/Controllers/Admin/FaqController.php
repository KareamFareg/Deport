<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Helpers\UtilHelper;
use Auth;


class FaqController extends AdminController
{

    public function __construct()
    {

        $this->share([
          'page' => Faq::PAGE,
          'recordsCount' => Faq::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      } 

      $data = Faq::all();

      $request->flash();

      return view('admin.faqs.index',compact(['data','trans']));

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

      Faq::create( array_merge( $request->all() , ['ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ] ) );

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      $request->flash();

      return back();

    }

    public function edit(Request $request)
    {


    }

    public function update(Request $request)
    {


      // $validate = $request->validate([
      //     'id' =>  'required|integer|exists:conditions,id',
      // ]);



      $faq = Faq::where('id',$request->id)->firstorfail();

      $request->merge([ 'question' => array_merge( $faq->question , $request->question) ]);
      $request->merge([ 'answer' => array_merge( $faq->answer , $request->answer) ]);

      Faq::where('id',$request->id)->first()->update($request->all());

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      $request->flash();

      return back();

    }

    public function destroy(Request $request)
    {

      if (Faq::find($request->route('id'))->delete()) {
        return response()->json(['success' => __('messages.deleted')]);
    } else {
        return response()->json(['error' => __('messages.deleted_faild')]);
    }

      

    }

}
