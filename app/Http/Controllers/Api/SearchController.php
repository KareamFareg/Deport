<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Helpers\UtilHelper;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchController extends Controller
{

    use ApiResponse;

  // public function liveSearch(Request $request)
  // {
  //
  //   $words = UtilHelper::ftextValidate($request->crit); // validateinput,replace string,execludes words less than 3 chr.
  //
  //   // for live search
  //   if ($request->ajax()) {
  //     $result = DB::Table('item_info')
  //       ->join('items','item_info.item_id','items.id')
  //       ->where('items.is_active',1)
  //     	->whereRaw("MATCH (for_search) AGAINST (? IN BOOLEAN MODE)", $words )
  //     	->selectRaw("item_info.title as value,item_info.item_id as item_id,
  //     							MATCH (for_search) AGAINST (? IN BOOLEAN MODE) as rel_score", [$words]) // item_info.title as value to can access it via auto complete
  //     							->limit(12)->get();
  //
  //     	return response()->json($result);
  //   }
  //
  // }

  public function search(Request $request)
  {

      $language = app()->getLocale();


      $this->validate($request, [
         'crit' => 'required|string',
         'user_id' => 'required|integer'
      ]);

      $user_id = $request->user_id;

      $words = UtilHelper::ftextValidate($request->crit);
      $words = str_replace('+','',$words);
      $words = str_replace('*','',$words);


      $data = Item::with(['user.client.client_info','item_type','files',
        'item_info' => function($query) use($language) {
            $query->where('language',$language);
        },
        'liked' => function ($query) use( $user_id ) { // get if user likes this item
            $query->where('user_id',$user_id);
        }
      ])->whereHas('item_info' , function($query) use($words) {
        $query->where('for_search','like','%'.$words.'%');
      })
      ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
      ->orderBy('id','desc')->paginate(5);


      if ( empty($data->all()) ) {
        throw new ModelNotFoundException;
      }

      return $this->responseSuccess([
        'data' =>  ItemResource::collection($data) ,
        'paginate' => [
          'total' => $data->total() ,
          'lastPage' => $data->lastPage() ,
          'currentPage' => $data->currentPage() ,
        ]
      ] , 206 );


  }




}
