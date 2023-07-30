<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Models\SubscriptionPackage;
use App\Services\UserService;
use App\Services\CategoryService;
use App\Services\UserTypeService;

use App\Helpers\UtilHelper;
use Auth;

class SubscriptionPackageController extends AdminController
{
    private $userServ;
    private $categoryServ;
    private $userTypeServ;

    public function __construct(UserService $userService,CategoryService $categoryService, UserTypeService $userTypeService)
    {
        $this->userServ = $userService;
        $this->categoryServ = $categoryService;
        $this->userTypeServ = $userTypeService;

        $this->share([
          'page' => SubscriptionPackage::PAGE,
          'recordsCount' => SubscriptionPackage::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {
        $language = $this->defaultLanguage;

        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 );

        $userTypes = \App\Models\UserType::all();

        $data = SubscriptionPackage::with(['category.category_info' => function($query) use ($language) {
            $query->where('language' , $language->locale);
        },'user_type']);

        if ($request->category_id){
            $data->where('category_id',$request->category_id);
        }

        if ($request->user_type_id){
            $data->where('user_type_id',$request->user_type_id);
        }

        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active',$request->active_status);
        };

        $data = $data->get();
        $request->flash();

        return view('admin.subscription_package.index',compact(['categories','userTypes','data']));
    }

    public function create()
    {
        $userTypes = $this->userTypeServ->getSubscriptionUserTypes();

        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 ) ;

        return view('admin.subscription_package.create',compact(['categories','userTypes']));

    }

    public function store(Request $request)
    {

      $request->merge([ 'title' => UtilHelper::formatNormal($request->title) ]);

      $validate = $request->validate([
          'title' => 'required|string|max:100|unique:subscription_packages',
          'category_id' => 'required|integer|exists:categories,id',
          'user_type_id' => 'required|integer|exists:user_type,id',
          'period' => 'required|integer|min:1|max:1000',
          'price' => 'required|numeric',
      ]);

      // subscriptio only for 1 shop , 2 free delegate
      $inSubscriptionUserTypes = $this->userTypeServ->checkInSubscriptionUserTypes($request->user_type_id);
      if (! $inSubscriptionUserTypes) {
        return back()->withinput()->withErrors(['general' => __('messages.error_data') ]);
      }


      $subscriptionPackage = new SubscriptionPackage();
      $subscriptionPackage->title = $request->title;
      $subscriptionPackage->category_id = $request->category_id;
      $subscriptionPackage->user_type_id = $request->user_type_id;
      $subscriptionPackage->period = $request->period;
      $subscriptionPackage->price = $request->price;
      $subscriptionPackage->ip = UtilHelper::getUserIp() ;
      $subscriptionPackage->access_user_id = Auth::id();
      $subscriptionPackage->save();


      return redirect(route('admin.subscriptionpackages.index'));

    }

    public function edit(Request $request)
    {

        $data = SubscriptionPackage::findOrFail($request->id);

        $userTypes = $this->userTypeServ->getSubscriptionUserTypes();

        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 ) ;

        return view('admin.subscription_package.edit',compact(['categories','userTypes','data']));

    }

    public function update(Request $request)
    {

      $request->merge([ 'title' => UtilHelper::formatNormal($request->title) ]);

      $validate = $request->validate([
          'title' => 'required|string|max:100|unique:subscription_packages,title,'.$request->id,
          'category_id' => 'required|integer|exists:categories,id',
          'user_type_id' => 'required|integer|exists:user_type,id',
          'period' => 'required|integer|min:1|max:1000',
          'price' => 'required|numeric',
      ]);

      // subscriptio only for 1 shop , 2 free delegate
      $inSubscriptionUserTypes = $this->userTypeServ->checkInSubscriptionUserTypes($request->user_type_id);
      if (! $inSubscriptionUserTypes) {
        return back()->withinput()->withErrors(['general' => __('messages.error_data') ]);
      }

      $subscriptionPackage = SubscriptionPackage::findOrFail($request->id);

      $subscriptionPackage->title = $request->title;
      $subscriptionPackage->category_id = $request->category_id;
      $subscriptionPackage->user_type_id = $request->user_type_id;
      $subscriptionPackage->period = $request->period;
      $subscriptionPackage->price = $request->price;
      $subscriptionPackage->ip = UtilHelper::getUserIp() ;
      $subscriptionPackage->access_user_id = Auth::id();
      $subscriptionPackage->save();


      return redirect(route('admin.subscriptionpackages.index'));


    }

    public function setActive(Request $request)
    {

        $subscriptionPackage = SubscriptionPackage::where('id',$request->id)->first();
        if (! $subscriptionPackage) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }


        $subscriptionPackage->update(['is_active' => !$subscriptionPackage->is_active ]);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }

        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();

    }


}
