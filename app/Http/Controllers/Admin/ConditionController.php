<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\Condition;
use App\Helpers\UtilHelper;


class ConditionController extends AdminController
{

    public function __construct()
    {

        $this->share([
          'page' => Condition::PAGE,
          'recordsCount' => Condition::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $trans = $this->defaultLanguage->locale;
      if ($request->isMethod('post')) {
        $trans = $request->trans;
      }


      $data = Condition::with(['category.category_info'=> function($query) use ($trans) {
          $query->where('language' , $trans);
      }]);


      $data = $data->get();
      // dd($data->first()->condition_1);

      $request->flash();

      return view('admin.conditions.index',compact(['data','trans']));

    }

    public function create()
    {

    }

    public function store(Request $request)
    {


    }

    public function edit(Request $request)
    {


    }

    public function update(Request $request)
    {


      // $validate = $request->validate([
      //     'id' =>  'required|integer|exists:conditions,id',
      // ]);

      $condition = Condition::where('id',$request->id)->firstorfail();

      $request->merge([ 'condition_1' => array_merge( $condition->condition_1 , $request->condition_1) ]);
      $request->merge([ 'condition_2' => array_merge( $condition->condition_2 , $request->condition_2) ]);
      $request->merge([ 'condition_3' => array_merge( $condition->condition_3 , $request->condition_3) ]);
      $request->merge([ 'contract' => array_merge( $condition->contract , $request->contract)  ]);


      Condition::where('id',$request->id)->first()->update($request->all());

      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      $request->flash();

      return back();

    }


}
