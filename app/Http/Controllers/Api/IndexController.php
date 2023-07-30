<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Models\Item;
use App\Services\ItemService;
use App\Traits\FileUpload;
use App\Helpers\UtilHelper;
use App\Http\Resources\ItemResource;

use App\Traits\ApiResponse;

class IndexController extends Controller
{

  use ApiResponse;
  use FileUpload;
  private $itemServ;

  public function __construct(ItemService $itemService)
  {
      $this->itemServ = $itemService;
  }

  public function index(Request $request)
  {

        $data = $this->itemServ->itemSummery([
          'where' => [ 'is_active' => 1 ],
          'user_id' => $request->user_id,
          'paginate'=> 4 ]);


        if ( empty($data->all()) ) {
          throw new ModelNotFoundException;
        }


        return $this->responseSuccessPages( [ 'data' =>  ItemResource::collection($data) ] , $data );

  }

  public function getOffers(Request $request)
  {
        $data = $this->itemServ->itemSummery([
            'where' => [ 'is_active' => 1 , 'type_id' => 1] ,
            'user_id' => $request->user_id,
            'paginate'=> 4 ]);

        if ( empty($data->all()) ) {
          throw new ModelNotFoundException;
        }

        return $this->responseSuccessPages( [ 'data' =>  ItemResource::collection($data) ] , $data );

        // return $this->responseSuccess([
        //   'data' =>  ItemResource::collection($data) ,
        //   'paginate' => [
        //     'total' => $data->total() ,
        //     'lastPage' => $data->lastPage() ,
        //     'currentPage' => $data->currentPage() ,
        //     'nextPageUrl' => $data->nextPageUrl(),
        //     'previousPageUrl' => $data->previousPageUrl()
        //   ]
        // ] , 206 );

  }

  public function getCoupons(Request $request)
  {
        $data = $this->itemServ->itemSummery([
            'where' => ['is_active' => 1 , 'type_id' => 2] ,
            'user_id' => $request->user_id,
            'paginate'=> 4 ]);

        if ( empty($data->all()) ) {
          throw new ModelNotFoundException;
        }

        return $this->responseSuccessPages( [ 'data' =>  ItemResource::collection($data) ] , $data );

        // return $this->responseSuccess([
        //   'data' =>  ItemResource::collection($data) ,
        //   'paginate' => [
        //     'total' => $data->total() ,
        //     'lastPage' => $data->lastPage() ,
        //     'currentPage' => $data->currentPage() ,
        //     'nextPageUrl' => $data->nextPageUrl(),
        //     'previousPageUrl' => $data->previousPageUrl()
        //   ]
        // ] , 206 );

  }

  


}
