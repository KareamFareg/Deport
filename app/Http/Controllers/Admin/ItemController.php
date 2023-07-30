<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

use App\Services\ItemService;
use App\Services\UserService;
// use App\Services\CategoryService;
// use App\Services\CountryService;
use App\Models\Item;
use App\Models\ItemInfo;
use App\Models\File;
use App\User;
use App\Models\Language;
use App\Helpers\UtilHelper;
// use App\Traits\FileUpload;
use Auth;

// use Yajra\Datatables\Datatables;

class ItemController extends AdminController
{
  // use FileUpload;
  private $itemServ;
  private $userServ;
  // private $categoryServ;
  // private $countryServ;
  private $defaultLanguage;

    public function __construct(ItemService $itemService, UserService $userService  )
    {
        $this->itemServ = $itemService;
        $this->userServ = $userService;
        // $this->categoryServ = $categoryService;
        // $this->countryServ = $countryService;

        $this->share([
          'page' => Item::PAGE,
          'recordsCount' => Item::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function show(Request $request)
    {

    }

    public function index(Request $request)
    {

        $data = Item::Info()->Coupon()->paginate(3);

        $this->share([
          'page' => Item::PAGE,
          'recordsCount' => $data->count(),
          'subTitle' => __('item.title'),
        ]);

        if ($request->ajax()) {
           return response()->json(array('status'=>'validation','html'=> view('components.admin.datatable.dt-items' ,['data'=> $data])->render() )); 
        }

        return view('admin.items.index',compact(['data']));

        //
        // $language = $this->defaultLanguage;
        // $categories = [];
        // $users = collect([]);
        // $mainUserId = $this->getMainUserId();
        //
        // // if user admin get all categories
        // if (Auth::user()->isAdmin()) {
        //   $categories = $this->categoryServ->getAll();
        //   $temp = [];
        //   $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 1, 0 ) ;
        //   $users = User::with(['client.client_info' => function($query) use ($language) {
        //       $query->where('language' , $language->locale);
        //   }])->WhereHas('client')->TypeClient()->get();
        // }
        //
        // // if user client get only his categories
        // if (Auth::user()->isClient()) {
        //   $categories = $this->userServ->showCategories($mainUserId);
        //   $categories = $this->userServ->showCategoriesFormat($categories);
        // }
        //
        //
        // $filters = [ 'fields' => 'select_default' , 'type' => 1];
        // // 1 category
        // $childrenIds = null;
        // if ($request->category_id) {
        //     $categoryService = new CategoryService();
        //     $childrenIds = $categoryService->getChildrenIds($request->category_id);
        //     if ($childrenIds) {
        //       $filters = $filters + ['category' => explode(',', $childrenIds) ];
        //     }
        // }
        // // 2 clients
        // if (Auth::user()->isClient()) {
        //   $filters = $filters + [ 'user' => $mainUserId ];
        // } else {
        //   $request->user_id ? ($filters = $filters + [ 'user' => $request->user_id ]) : '';
        // }
        // // 3 active
        // if ($request->active_status === "0" || $request->active_status === "1" ) {
        //   $filters = $filters + [ 'active' => $request->active_status ] ;
        // };
        //
        // $data = [];
        // $request->flash();
        // $data = $this->itemServ->queryAll($filters);
        //
        // return view('admin.items.index',compact(['categories','users','data']));

    }


    public function indexCoupons(Request $request)
    {


        $language = $this->defaultLanguage;

        $data = Item::Info()->Coupon();

        // 3 active
        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active' , $request->active_status);
        };

        $request->flash();

        $data = $data->get();
        $this->share([
          'page' => Item::PAGE,
          'recordsCount' => $data->count(),
          'subTitle' => __('item.title_coupons'),
        ]);
        return view('admin.items.index-coupons',compact(['data']));

    }


    public function indexOffers(Request $request)
    {


        $language = $this->defaultLanguage;

        $data = Item::Info()->offer();

        // 3 active
        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active' , $request->active_status);
        };

        $request->flash();

        $data = $data->get();
        $this->share([
          'page' => Item::PAGE,
          'recordsCount' => $data->count(),
          'subTitle' => __('item.title_offers'),
        ]);

        return view('admin.items.index-offers',compact(['data']));

    }

    public function getMost(Request $request)
    {


        $request->merge([ 'type' => $request->route('type') ]);

        $request->validate([
          'type' => 'required|string|in:likes,views,comments,latest',
        ] ,[] ,[ 'type' => 'النوع' ]);

        $language = $this->defaultLanguage;

        $data = Item::Info();

        $subTitle = '';
        switch ($request->type) {
          case "likes":
            $data = $data->orderBy('likes','desc')->limit(20);
            $subTitle = __('words.most_likes');
            break;
          case "views":
          $data = $data->orderBy('views','desc')->limit(20);
            $subTitle = __('words.most_views');
            break;
          case "comments":
            $data = $data->orderBy('comments','desc')->limit(20);
            $subTitle = __('words.most_comments');
            break;
            case "latest":
              $data = $data->orderBy('created_at','desc')->limit(20);
              $subTitle = __('words.latest');
              break;
          default:
            $subTitle = '';
        }

        $this->share([
          'page' => Item::PAGE,
          'recordsCount' => $data->count(),
          'subTitle' => $subTitle,
        ]);

        // 3 active
        if ($request->active_status === "0" || $request->active_status === "1" ) {
          $data->where('is_active' , $request->active_status);
        };

        $request->flash();

        $data = $data->get();

        return view('admin.items.most-type',compact(['data']));

    }

    public function create()
    {

        // $language = $this->defaultLanguage;
        // $categories = [];
        // $users = collect([]);
        //
        // // if user admin get all categories
        // if (Auth::user()->isAdmin()) {
        //   $categories = $this->categoryServ->getAll();
        //   $temp = [];
        //   $categories = UtilHelper::buildTreeRoot( $categories, null, $temp, 1, 0 ) ;
        //   $users = User::with(['client.client_info' => function($query) use ($language) {
        //       $query->where('language' , $language->locale);
        //   }])->WhereHas('client')->TypeClient()->get();
        // }
        //
        // // if user client get only his categories
        // if (Auth::user()->isClient()) {
        //   $mainUserId = $this->getMainUserId();
        //   $categories = $this->userServ->showCategories($mainUserId);
        //   $categories = $this->userServ->showCategoriesFormat($categories);
        // }
        //
        // return view('admin.items.create',compact(['categories','users']));

    }

    public function store(ItemRequest $request)
    {

      // check title,language doublicate in info table
      // $chkTitle = ItemInfo::where('title',$request['title'])->where('language',$request['language'])->exists();
      // if ($chkTitle) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      // }
      //
      //
      // // check alias,language doublicate in info table
      // $chkAlias = ItemInfo::where('alias',$request['alias'])->where('language',$request['language'])->exists();
      // if ($chkAlias) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language') ]);
      // }
      //
      // $user_id = Auth::id();
      // if (Auth::user()->isAdmin()) {
      //   $user_id = $request['user_id'];
      // }
      //
      // // check category in current user categories ???????
      //
      // $item = $this->itemServ->storeItem($request->validated() + ['user_id' => $user_id , 'type_id' => 1]);
      // $itemInfo = $this->itemServ->storeItemInfo($request->validated() + [ 'item_id' => $item->id ]);
      // $itemCategory = $this->itemServ->storeItemCategory( $request['category_id'] ,$item->id);
      //
      // // upload image
      // if( $request->hasFile('image') ) {
      //     $path = $this->storeFile($request , [
      //         'fileUpload' => 'image',
      //         'folder' => Item::FILE_FOLDER,
      //         'recordId' => $itemInfo->id,
      //     ]);
      //     $itemInfo->Update(['image' => $path]);
      // }
      //
      //
      // return redirect(route('admin.items.index'));

    }

    public function edit(Request $request)
    {

      $item = Item::Info()->where('id',$request->id)->first();
      if (!$item) { abort(404); }

      $this->share([
        'page' => Item::PAGE,
        'subTitle' => __('item.images_control'),
      ]);

      return view('admin.items.edit',compact('item'));

    }

    public function update(ItemRequest $request)
    {

      // $itemInfo = ItemInfo::findOrFail($request->id);
      // $item = item::with(['category'])->where('id',$itemInfo->item_id)->firstorfail();
      //
      // if (Auth::user()->isClient()) {
      //   $mainUserId = $this->getMainUserId();
      //   if ($mainUserId != $item->user_id){
      //     $this->flashAlert([
      //       'faild' => ['msg'=> __('messages.not_your_product')]
      //     ]);
      //     return redirect(route('admin.items.index'));
      //   }
      // }
      //
      //
      //
      // // check title,language doublicate in info table
      // $chkTitle = ItemInfo::where('title',$request['title'])->where('language',$request['language'])->where('id','!=',$request->id)->exists();
      // if ($chkTitle) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      // }
      //
      // // check alias,language doublicate in info table
      // $chkAlias = ItemInfo::where('alias',$request['alias'])->where('language',$request['language'])->where('id','!=',$request->id)->exists();
      // if ($chkAlias) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language') ]);
      // }
      //
      //
      // $user_id = Auth::id();
      // if (Auth::user()->isAdmin()) {
      //   $user_id = $request['user_id'];
      // }
      //
      // // check category in current user categories ???????
      //
      // $itemInfo = $this->itemServ->updateItemInfo($request->validated() , $itemInfo);
      // $item = $this->itemServ->updateItem($request->validated() + ['user_id' => $user_id], $item);
      // $itemCategory = $this->itemServ->updateItemCategory( $request['category_id'] ,$item->id);
      //
      //
      //
      //
      // // upload image
      // if( $request->hasFile('image') ) {
      //     $path = $this->storeFile($request , [
      //         'fileUpload' => 'image',
      //         'folder' => Item::FILE_FOLDER,
      //         'recordId' => $itemInfo->id,
      //     ]);
      //     $itemInfo->Update(['image' => $path]);
      // }
      //
      //
      // return redirect(route('admin.items.index'));

    }

    public function storeTrans(ItemRequest $request)
    {

      // $item = Item::findOrFail($request->id);
      //
      // if (Auth::user()->isClient()) {
      //   $mainUserId = $this->getMainUserId();
      //   if ($mainUserId != $item->user_id){
      //     $this->flashAlert([
      //       'faild' => ['msg'=> __('messages.not_your_product')]
      //     ]);
      //     return redirect(route('admin.items.index'));
      //   }
      // }
      //
      // $checkDoublLang = ItemInfo::where('item_id',$request->id)->where('language',$request['language'])->exists();
      // if ($checkDoublLang) {
      //   return back()->withinput()->withErrors(['general' => __('messages.duplicate_category_language') ]);
      // }
      //
      // // check title,language doublicate in info table
      // $chkTitle = ItemInfo::where('title',$request['title'])->where('language',$request['language'])->exists();
      // if ($chkTitle) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language') ]);
      // }
      //
      //
      // // check alias,language doublicate in info table
      // $chkAlias = ItemInfo::where('alias',$request['alias'])->where('language',$request['language'])->exists();
      // if ($chkAlias) {
      //   return back()->withinput()->withErrors(['title' => __('messages.duplicate_alias_language') ]);
      // }
      //
      //
      // $user_id = Auth::id();
      // if (Auth::user()->isAdmin()) {
      //   $user_id = $request['user_id'];
      // }
      //
      // // check category in current user categories ???????
      //
      // $item = $this->itemServ->updateItem($request->validated() + ['user_id' => $user_id] , $item);
      // $itemInfo = $this->itemServ->storeItemInfo($request->validated() + [ 'item_id' => $item->id ]);
      //
      //
      // // upload image
      // if( $request->hasFile('image') ) {
      //     $path = $this->storeFile($request , [
      //         'fileUpload' => 'image',
      //         'folder' => Item::FILE_FOLDER,
      //         'recordId' => $itemInfo->id,
      //     ]);
      //     $itemInfo->Update(['image' => $path]);
      // }
      //
      //
      // return redirect(route('admin.items.index'));

    }

    public function setActive(Request $request)
    {

        $item = Item::where('id',$request->id)->first();
        if (! $item) {
          if ($request->ajax()) {
            return response()->json(['status'=>'error', 'msg'=>__('messages.not_found'), 'alert'=>'swal' ]);
          }
          $this->flashAlert([ 'faild' => ['msg'=> __('messages.not_found')] ]);
          return back();
        }

        $status = !$item->is_active;

        $this->itemServ->setActive($item , $status);
        if ($request->ajax()) {
          return response()->json(['status'=>'success', 'msg'=>__('messages.updated'), 'alert'=>'swal' ]);
        }
        $this->flashAlert([ 'success' => ['msg'=> __('messages.updated') ] ]);
        return back();


    }

    public function getMainUserId()
    {
      // return (Auth::user()->client_id == 0) ? Auth::id() : Auth::user()->client_id;
    }

    public function destroy()
    {
      // check item belong to client

    }

    public function destroyFile(Request $request)
    {


        if (! File::destroy($request->route('file_id')) ) {
            return back()->withinput()->withErrors(['delete' => __('messages.deleted_faild') ]);
        }

        $this->flashAlert([
          'success' => ['msg'=> __('messages.deleted') ]
        ]);

        return back()->withinput();

    }
}
