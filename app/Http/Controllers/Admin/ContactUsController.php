<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\ContactUs;
use App\Helpers\UtilHelper;
use Auth;

class ContactUsController extends AdminController
{

    public function __construct()
    {

        $this->share([
          'page' => ContactUs::PAGE,
          'recordsCount' => ContactUs::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

      $language = $this->defaultLanguage;

      $data = ContactUs::with(['type','user:id,name,phone'])->select('id','title','mobile','contact_us_type_id','ip','user_id','created_at')->orderBy('id','desc')->get();

      return view('admin.contact_us.index',compact(['data']));

    }

    public function getDetails(Request $request)
    {

        $data = ContactUs::where('id',$request->route('id'))->first();
        if ($data) {
          return response()->json([ 'status' => 'success' , 'html' => $data->description ]);
        }

        return response()->json([ 'status' => 'success' , 'html' => 'No data' ]);

    }

    public function create(Request $request)
    {

      $contactUsTypes = \App\Models\ContactUsType::all();

      return view('admin.contact_us.create',compact('contactUsTypes'));
    }

    public function store(Request $request)
    {

      $validate = $request->validate([
          'title' => 'required|string|max:100',
          'mobile' => 'required|numeric|digits:10',
          'contact_us_type_id' => 'required|exists:contact_us_types,id',
          'description' => 'required|max:4000',
      ]);

      ContactUs::create( array_merge(
        $request->all() , [ 'user_id' => Auth::id() , 'ip' => UtilHelper::getUserIp() ] )
      );


      $this->flashAlert([
        'success' => ['msg'=> __('messages.contact_us_sent')]
      ]);

      return back();


    }

}
