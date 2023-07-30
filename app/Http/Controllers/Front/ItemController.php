<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Item;
use App\Models\ItemInfo;
use App\Models\ItemType;
use App\Models\File;
use App\Models\AdvPeriod;
use App\Http\Requests\ItemRequest;
use App\Models\ULike;
use App\Services\ItemService;
use App\Services\CommonService;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\View;
use Auth;
use App\Helpers\UtilHelper;

class ItemController extends Controller
{

    private $itemServ;
    private $commonServ;
    private $commentServ;
    private $userServ;
    private $notificationServ;


    public function __construct(
      ItemService $itemService,
      CommonService $commonService,
      CommentService $commentService,
      UserService $userService,
      NotificationService $notificationService)
    {
        $this->itemServ = $itemService;
        $this->commonServ = $commonService;
        $this->commentServ = $commentService;
        $this->userServ = $userService;
        $this->notificationServ = $notificationService;


        $this->share([
          'page' => Item::PAGE,
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index()
    {
        // return view('front.index');
    }

    public function show(Request $request)
    {

      $item = $this->itemServ->itemSummery([
        'where' => [
            'id' => $request->id,
            'is_active' => 1,
        ],
        'paginate'=> 0 ])->first();



        if (!$item) { abort(404); }
        if ($item->item_info->isEmpty()) { abort(404); }

        $item = $this->commonServ->incrementItemViews($request->id);


        $this->seoInfo('item',$item);
        return view('front.item',compact('item'));

    }

    public function edit(Request $request)
    {

        $item = $this->itemServ->itemSummery([
          'where' => [
              'id' => $request->id,
              'is_active' => 1,
          ]
         ])->first();


          if (!$item) { abort(404); }

          $auth = $this->checkCurrentAuth($item->user_id);
          if ( $auth == false) {
            abort(404);
          }

          $user = $this->userServ->getUserById(Auth::id());
          if (!$user) { abort(404); }

          $types = ItemType::all();
          $advPeriods = AdvPeriod::limited()->get();

          $page = 'item_edit';

          return view('front.users.many-data',compact(['user','item','page','types','advPeriods']));

    }

    public function update(ItemRequest $request)
    {

        $language = app()->getlocale();

        $item = Item::findOrFail($request->id);
        $itemInfo = ItemInfo::where('item_id',$request->id)->where('language',$language)->first();

        $data = $request->validated();


        $updateItemInfo = $itemInfo->update([
            'title' => $data['title'],
            'alias' => $data['alias'],
            'description' => $data['description'],
            'for_search' => $data['description'],
            'ip' => UtilHelper::getUserIp() ,
            'access_user_id' => Auth::id(),
          ]
        );


        $endDate = $this->itemServ->noEndDate();
        if ($data['type_id'] == 1) {
          $period = AdvPeriod::where('id' ,$data['adv_period_id'])->select('period')->first();
          $endDate = $this->itemServ->calculateAdvPeriods(UtilHelper::currentDate(),$period->period );
        }

        $updateItem = $item->Update([
              'type_id' => $data['type_id'],
              'adv_period_id' => isset($data['adv_period_id']) ? $data['adv_period_id'] : $this->itemServ->getOpenedPeriod()->id,
              'links' => $data['links'],
              'title_general' => $request->title_general,
              'end_date' => $endDate,
              'ip' => UtilHelper::getUserIp() ,
              'access_user_id' => Auth::id(),
              ]
        );




      if ($request->img_0) {
          // delete if the first one has file
          File::where([ 'file_type_id' => 1, 'table_name' => 'items', 'table_id' => $item->id])->delete();

          $storeImage = $this->itemServ->storeImages( $request->img_0, $itemInfo->id,
            $item->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }

      if ($request->img_1) {
          $storeImage = $this->itemServ->storeImages( $request->img_1, $itemInfo->id,
            $item->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }

      if ($request->img_2) {
          $storeImage = $this->itemServ->storeImages( $request->img_2, $itemInfo->id,
            $item->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }


      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated')]
      ]);
      return back();


    }

    public function store(ItemRequest $request)
    {

      $language = $this->defaultLanguage->locale;

      $data = $request->validated();

      $endDate = $this->itemServ->noEndDate();
      if ($data['type_id'] == 1) {
        $period = AdvPeriod::where('id' ,$data['adv_period_id'])->select('period')->first();
        $endDate = $this->itemServ->calculateAdvPeriods(UtilHelper::currentDate(),$period->period );
      }

      $storeItem = new Item();
      $storeItem->type_id = $data['type_id'];
      $storeItem->adv_period_id = isset($data['adv_period_id']) ? $data['adv_period_id'] : $this->itemServ->getOpenedPeriod()->id;
      $storeItem->links = $data['links'];
      $storeItem->title_general = $data['title'];
      $storeItem->ip = UtilHelper::getUserIp() ;
      $storeItem->user_id = Auth::id();
      $storeItem->access_user_id = Auth::id();
      $storeItem->end_date = $endDate;
      $storeItem->save();

      // $storeItem = Item::forceCreate([
      //       'type_id' => $data['type_id'],
      //       'adv_period_id' => $data['adv_period_id'],
      //       'links' => $data['links'],
      //       // 'title_general' => $data['title'],
      //       'ip' => UtilHelper::getUserIp() ,
      //       'user_id' => Auth::id(),
      //       'access_user_id' => Auth::id()
      //       ]
      // );


      // $title = substr($data['description'], 0, 20);

      $storeItemInfo = new ItemInfo();
      $storeItemInfo->language = $language ;
      $storeItemInfo->item_id = $storeItem->id;
      $storeItemInfo->title = $data['title'];
      $storeItemInfo->alias = $data['alias'];
      $storeItemInfo->description = $data['description'];
      $storeItemInfo->for_search = $data['description'];
      $storeItemInfo->ip = UtilHelper::getUserIp();
      $storeItemInfo->access_user_id = Auth::id();
      $storeItemInfo->save();


      if ($request->img_0) {
          $storeImage = $this->itemServ->storeImages( $request->img_0, $storeItemInfo->id,
            $storeItem->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }

      if ($request->img_1) {
          $storeImage = $this->itemServ->storeImages( $request->img_1, $storeItemInfo->id,
            $storeItem->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }

      if ($request->img_2) {
          $storeImage = $this->itemServ->storeImages( $request->img_2, $storeItemInfo->id,
            $storeItem->id, Auth::id(), 1 );

          if (! $storeImage){
            $this->flashAlert([
              'faild' => ['msg'=> __('messages.error_upload_image')]
            ]);
            return back()->withinput();
          }
      }


      $this->flashAlert([
        'success' => ['msg'=> __('messages.added')]
      ]);
      return back();

    }

    public function delete(Request $request)
    {

        DB::transaction(function() use($request) {
          DB::table('comments')->where([ 'table_id' => $request->id , 'table_name' => 'items' ])->delete();
          DB::table('likes')->where([ 'table_id' => $request->id , 'table_name' => 'items' ])->delete();
          DB::table('files')->where([ 'table_id' => $request->id , 'table_name' => 'items' , 'file_type_id' => 1 ])->delete();
          DB::table('item_info')->where('item_id',$request->id)->delete();
          DB::table('items')->where('id',$request->id)->delete();
        });


        $this->flashAlert([
          'success' => ['msg'=> __('messages.deleted')]
        ]);

        return response()->json(array('status'=>'success','redir'=> 'true'));

    }

    public function storeLike(Request $request)
    {


      $validate = $this->commonServ->validateStoreLike($request->all());
      if ($validate !== true) {
          $errors = UtilHelper::prepareErrorBag($validate);

          if ($request->ajax())
          { return response()->json(array('status'=>'validation','msg'=> view('components.alert' ,['msg'=> $errors ,'msgType'=>'danger'])->render() )); }
          return redirect()->back();
      }





      $validateDoublicateLike = $this->commonServ->validateDoublicateLike( array_merge(
          $request->all() , [ 'user_id' => Auth::id() ]
        )
      );

      if ($validateDoublicateLike){
                 $request->merge(['user_id' => Auth::id()]);
                 $ULike = $this->commonServ->disLike( $request );
                 if ($ULike) {
                     $item = $this->commonServ->decrementItemLikes($request->table_id);
                 }
      } else {
                 $ULike = $this->commonServ->storeLike( array_merge(
                       $request->all() , [
                         'user_id' => Auth::id(),
                         'ip' => UtilHelper::getUserIp(),
                         'access_user_id' => Auth::id()
                       ]
                     )
                  );


                  if ($ULike) {
                        $item = $this->commonServ->incrementItemLikes($request->table_id);

                        // notify , check if user like his product so don't notify
                        if ( ! $this->itemServ->checkItemBelongsToUser($request->table_id,Auth::id()) ) {
                          $this->notificationServ->notifyLike(
                              ['fcm','web','db'] ,
                              ['user_sender_id' => Auth::id() , 'item_id' => $request->table_id ]
                          );
                        }
                  }
      }



      if ($request->ajax())
      { return response()->json(array('status'=>'success','itemLikes'=> $item->likes , 'userLikes' => $this->userServ->getUserLikesCount(Auth::id()) )); }
      return redirect()->back();


    }

    public function getComments(Request $request)
    {

      $data = $this->commentServ->getCommentsRootOfItem($request->id);

      if ($request->ajax())
      { return response()->json(array(
          'status' => 'success',
          'html' => view('components.front.comments.comments' , [ 'comments' => $data->all() ])->render(),
          'paginate' => view('components.front.comments.comments-paginate' , [
              'itemId' => $request->id ,
              'paginate' => [
                'total' => $data->total() ,
                'lastPage' => $data->lastPage() ,
                'currentPage' => $data->currentPage() ,
              ]
            ])->render()
          )
        );
      }

      return redirect()->back();

    }


    public function destroyFile(Request $request)
    {

      $file = File::where('id',$request->route('file_id'))->first();
      if (! $file) {
        throw new ModelNotFoundException;
      }

      $fileBelongsToUser = $this->itemServ->checkFileBelongsToUser($file->table_id , Auth::id());
      if (! $fileBelongsToUser) {
        $response = [ 'errors' => [ 'delete' => __('messages.error_belongs_to_user')] ];
        return $this->responseFaild($response,401);
      }

        if (! File::destroy($request->route('file_id')) ) {
            return back()->withinput()->withErrors(['delete' => __('messages.deleted_faild') ]);
        }

        $this->flashAlert([
          'success' => ['msg'=> __('messages.deleted') ]
        ]);

        return back()->withinput();

    }


    public function checkCurrentAuth($user_id)
    {

      $auth = false;
      if (Auth::id() == $user_id) {
        $auth = true;
      }

      View::share('auth',$auth);
      return $auth;

    }

}
