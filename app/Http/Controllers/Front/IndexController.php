<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\AdvPeriod;
use App\Services\ItemService;
use App\Traits\FileUpload;
use App\Helpers\UtilHelper;
use Auth;
// use Illuminate\Validation\ValidationException;


class IndexController extends Controller
{
  use FileUpload;
  private $itemServ;

  public function __construct(ItemService $itemService)
  {
      $this->itemServ = $itemService;

      $this->share([
        'page' => Item::PAGE,
      ]);

      $this->defaultLanguage = $this->defaultLanguage();

  }

    public function index(Request $request)
    {

      // $data = $this->itemServ->itemSummery([
      //   'where' => [ 'is_active' => 1 ],
      //   'paginate'=> 4 ]);


      // if ($request->ajax()) {
      //     return response()->json(array(
      //     'status' => 'success',
      //     'html' => view('components.front.items' , [ 'data' => $data ])->render(),
      //     'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
      //     )
      //   );
      // };

      // $this->seoInfo('home','');
      // return view('front.index', compact(['data']));

    }

    public function getOffers(Request $request)
    {
      $data = $this->itemServ->itemSummery([
          'where' => [ 'is_active' => 1 , 'type_id' => 1] ,
          'paginate'=> 4 ]);

      if ($request->ajax()) {
          return response()->json(array(
          'status' => 'success',
          'html' => view('components.front.items' , [ 'data' => $data ])->render(),
          'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
          )
        );
      };

      $this->seoInfo('home','');
      $this->share([
        'page' => 'offers',
      ]);

      return view('front.index', compact('data'));

    }

    public function getCoupons(Request $request)
    {
      $data = $this->itemServ->itemSummery([
          'where' => ['is_active' => 1 , 'type_id' => 2] ,
          'paginate'=> 4 ]);

      if ($request->ajax()) {
          return response()->json(array(
          'status' => 'success',
          'html' => view('components.front.items' , [ 'data' => $data ])->render(),
          'paginate' => view('components.front.paginate' , [ 'nextUrl' => $data->nextPageUrl() ])->render()
          )
        );
      };

      $this->seoInfo('home','');
      $this->share([
        'page' => 'coupons',
      ]);
      return view('front.index', compact('data'));

    }


    public function testUploadImg(Request $request)
    {


      // upload image
      if( $request->hasFile('image') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'image',
              'folder' => 'settings',
              'recordId' => 1,
          ]);
      }

      dd('Done');


    }

}
