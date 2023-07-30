<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\BadWords;
use App\Helpers\UtilHelper;
use Auth;


class BadWordsController extends AdminController
{

    public function __construct()
    {

        $this->share([
          'page' => BadWOrds::PAGE,
          // 'recordsCount' => Faq::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      }

      $data = BadWords::where('language_id',$trans)->first();
      $words = implode(',',$data->words);

      $request->flash();

      return view('admin.badwords.index-edit',compact(['data','words','trans']));

    }


    public function update(Request $request)
    {

      // $validate = $request->validate([
      //     'id' =>  'required|integer|exists:bad_words,id',
      // ]);

      $badwords = BadWords::where('id',$request->id)->firstorfail();

      $words = UtilHelper::formatNormal($request->words);

      $words = explode(',', $words);

      $badwords->update(['words' => $words]);

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      $request->flash();

      return back();

    }


}
