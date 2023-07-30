<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ClientTransRequest;

use App\Services\UserService;
use App\Services\CountryService;
use App\Services\ClientService;
use App\Services\CategoryService;
use App\Services\UserCategoryService;
use App\Models\Client;
use App\Models\ClientInfo;
use App\Models\Country;
use App\Models\Language;
use App\User;

use App\Helpers\UtilHelper;
use App\Traits\FileUpload;
use Auth;

class ClientController extends AdminController
{
  use FileUpload;
  private $userServ;
  private $countryServ;
  private $clientServ;
  private $categoryServ;
  private $defaultLanguage;

  public function __construct(
    UserService $userService,
    CountryService $countryService,
    ClientService $clientService,
    CategoryService $categoryService,
    UserCategoryService $userCategoryService )
  {
      $this->userServ = $userService;
      $this->countryServ = $countryService;
      $this->clientServ = $clientService;
      $this->categoryServ = $categoryService;
      $this->userCategoryServ = $userCategoryService;

      $this->share([
        'page' => Client::PAGE,
        'recordsCount' => Client::count(),
      ]);

      $this->defaultLanguage = $this->defaultLanguage();

  }

    public function index(Request $request)
    {

        $language = $this->defaultLanguage;

        $categories = collect([]);
        $data = collect([]);
        $userTypes = collect([]);
        $categoryId = $request->category_id;

        if (Auth::user()->isAdmin()) {
          $categories = $this->categoryServ->getAll();
          $temp = [];
          $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 0, 0 ) ;


          $data = User::with(['client.client_info' => function($query) use ($language) {
              $query->where('language' , $language->locale);
          },'categories.category_info'])->TypeClient();

          if ($request->type_id) {
            $data->where('type_id',$request->type_id);
          }

          if ($request->category_id) {
            $data->whereHas('categories' , function ($query) use($categoryId) {
                $query->where('category_id', $categoryId);
            });
          };

          if ($request->active_status === "0" || $request->active_status === "1" ) {
            $data->where('is_active',$request->active_status);
          };

          $request->flash();
          $data = $data->get();

        }

        if (Auth::user()->isClient()) {
          $data = User::where('id', Auth::id())->orwhere('client_id',Auth::id())->get();
        }

        return view('admin.clients.index',compact(['categories','data']));

    }

    public function create()
    {

    }

    public function store(ClientRequest $request)
    {

    }

    public function edit(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
          $trans = $request->trans;
        }

        $data = Client::with(['user','client_info' => function($query) use($trans) {
            $query->where('language', $trans );
        }])->where('id',$request->id)->firstorfail();

        $data->categories = $data->user->categories->pluck('id')->toArray();


        if (Auth::user()->isClient()) {
          $currentClientId = 0;
          if (Auth::user()->client_id == 0) { // main client
            $currentClientId = Auth::user()->client->id;
          }
          if (Auth::user()->client_id != 0) { // client belongs to main client
            $currentClientId = Client::where('user_id', Auth::user()->client_id)->first()->id;
          }
          if ($data->id != $currentClientId) {
            $this->flashAlert([
              'faild' => ['msg'=> __('auth.unauthorized')]
            ]);
            return redirect(route('admin.home'));
          }
        }


        $countries = $this->countryServ->getAll();
        $temp = [];
        $countries = UtilHelper::buildTreeRoot( $countries, null, $temp, 1, 0 ) ;

        $categories = $this->categoryServ->getAll();
        $temp = [];
        $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 1, 0 ) ;

        return view('admin.clients.edit',compact(['countries','categories','trans','data']));

    }

    public function update(ClientRequest $request)
    {


      $clientInfo = ClientInfo::findOrFail($request->id);
      $client = Client::findOrFail($clientInfo->client_id);
      $user = User::findOrFail($client->user_id);


      $compareWithOldData = $this->compareWithOldData($request->validated() , $clientInfo , $client , $user);


      // check dublicate title
      $checkTitle = ClientInfo::where('title',$request->name)->where('language',$request->language)->where('id','!=',$request->id)->exists();
      if ($checkTitle){
        return back()->withinput()->withErrors(['name' => __('messages.duplicate_title_language') ]);
      }

      // check dublicate email
      $checkEmail = User::where('email',$request->email)->where('id','!=',$user->id)->exists();
      if ($checkEmail){
        return back()->withinput()->withErrors(['email' => __('messages.duplicate_email') ]);
      }



      // update
      $clientInfo = $this->clientServ->updateInfo( $request->validated() , $clientInfo );
      if (! $clientInfo) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }


      $client = $this->clientServ->update( $request->validated() , $client );
      if (! $client) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }


      $user = $this->userServ->update( $request->validated() , $user );
      if (! $user) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }


      $userCategory = $this->userCategoryServ->storeMany($request->validated() , $user->id);
      if (! $userCategory) {
        return back()->withinput()->withErrors(['general' => __('messages.updated_faild') ]);
      }

      // upload logo
      if( $request->hasFile('logo') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'logo',
              'folder' => Client::FILE_FOLDER,
              'recordId' => $clientInfo->id,
              'prifex' => 'logo_'.$request->language,
          ]);
          $clientInfo->Update(['logo' => $path]);
      }

      // upload banner
      if( $request->hasFile('banner') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'banner',
              'folder' => Client::FILE_FOLDER,
              'recordId' => $clientInfo->id,
              'prifex' => 'banner_'.$request->language,
          ]);
          $clientInfo->Update(['banner' => $path]);
      }

      if ($compareWithOldData == true) {
          if (! Auth::user()->isAdmin()) {
            $user->Update(['is_active' => 0]);
            Auth::logout();
          }
      }

      return redirect()->route('admin.clients.index');

    }

    public function storeTrans(ClientTransRequest $request)
    {

      $client =  Client::findOrFail($request->id);
      $clientInfo = ClientInfo::findOrFail($client->id);
      $user = User::findOrFail($client->user_id);


      $checkDoublLang = ClientInfo::where('client_id',$request->id)->where('language',$request->language)->exists();
      if ($checkDoublLang) {
        return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language') ]);
      }

      // check title,language doublicate in info table
      $chkTitle = ClientInfo::where('title',$request->title)->where('language',$request->language)->exists();
      if ($chkTitle) {
        return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      }

      // check dublicate email
      $checkEmail = User::where('email',$request->email)->where('id','!=',$user->id)->exists();
      if ($checkEmail){
        return back()->withinput()->withErrors(['email' => __('messages.duplicate_email') ]);
      }



      $client = $this->clientServ->update( $request->validated() , $client );
      $clientInfo = $this->clientServ->storeInfo( array_merge(
        $request->validated() , [ 'user_id' => Auth::id(), 'client_id' => $client->id ]
      ));
      $user = $this->userServ->update( $request->validated() , $user );
      $userCategory = $this->userCategoryServ->storeMany($request->validated() , $user->id);



      // upload logo
      if( $request->hasFile('logo') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'logo',
              'folder' => Client::FILE_FOLDER,
              'recordId' => $clientInfo->id,
              'prifex' => 'logo_'.$request->language,
          ]);
          $clientInfo->Update(['logo' => $path]);
      }

      // upload banner
      if( $request->hasFile('banner') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'banner',
              'folder' => Client::FILE_FOLDER,
              'recordId' => $clientInfo->id,
              'prifex' => 'banner_'.$request->language,
          ]);
          $clientInfo->Update(['banner' => $path]);
      }



      return redirect(route('admin.clients.index'));

    }

    public function setActive(Request $request)
    {

        $category = Category::findOrFail($request->id);
        $status = !$category->is_active;

        // if we try to active a category so check the parent of it if the parent is inactive then make it active
        if ($status == 1) {
          $parent = Category::where(['id' => $category->parent_id , 'is_active' => 0 ])->first();
          if ($parent){
            $this->flashAlert([ 'faild' => ['msg'=> __('category.activate_parent') .' - '. $parent->translation->first()->title ] ]);
            return back();
          }
        }

        $this->itemServ->setActive($category , $status);
        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();


    }

    public function compareWithOldData($request , $clientInfo , $client , $user)
    {


      if ( $clientInfo->title != $request['name'] ) { return true; }
      if ( $clientInfo->address != $request['address'] ) { return true; }
      if ( $clientInfo->description != $request['description'] ) { return true; }
      if ( $clientInfo->work_times != $request['work_times'] ) { return true; }

      if ( $client->country_id = $request['country_id'] ) { return true; }
      if ( $client->contacts = $request['contacts'] ) { return true; }
      if ( $client->email = $request['email'] ) { return true; }
      if ( $client->phone = $request['phone'] ) { return true; }
      if ( $client->commerce_no = $request['commerce_no'] ) { return true; }
      if ( $client->mobile = $request['mobile'] ) { return true; }
      if ( $client->administrator = $request['administrator'] ) { return true; }

      if ( $user->name = $request['name'] ) { return true; }
      if ( $user->email = $request['email']  ) { return true; }
      if ( $user->phone = $request['phone'] ) { return true; }
      if (isset($request['lat'])) {
        if ( $user->lat = $request['lat'] ) { return true; }
      }
      if (isset($request['lng'])) {
        if ( $user->lng = $request['lng'] ) { return true; }
      }

      if (isset($request['subscription_package_id'])) {
        if ( $user->subscription_package_id = $request['subscription_package_id'] ) { return true; }
      }

      return false;

    }

}
