<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Helpers\UtilHelper;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{

  public function liveSearch(Request $request)
  {

    $words = UtilHelper::ftextValidate($request->crit); // validateinput,replace string,execludes words less than 3 chr.

    // for live search
    if ($request->ajax()) {
      $result = DB::Table('item_info')
        ->join('items','item_info.item_id','items.id')
        ->where('items.is_active',1)
        ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
      	->whereRaw("MATCH (for_search) AGAINST (? IN BOOLEAN MODE)", $words )
      	->selectRaw("item_info.title as value,item_info.item_id as item_id,
      							MATCH (for_search) AGAINST (? IN BOOLEAN MODE) as rel_score", [$words]) // item_info.title as value to can access it via auto complete
      							->limit(12)->get();

      	return response()->json($result);
    }

  }

  public function search(Request $request)
  {


      $language = app()->getLocale();

      $crit ='';
      if ($request->live_search) {
        $crit = $request->live_search;
      }


      $words = UtilHelper::ftextValidate($crit);
      $words = str_replace('+','',$words);
      $words = str_replace('*','',$words);


      $data = Item::with(['user.client.client_info','item_type','files','item_info' => function($query) use($language) {
        $query->where('language',$language);
      }])->whereHas('item_info' , function($query) use($words) {
        $query->where('for_search','like','%'.$words.'%');
      })
      ->wheredate('end_date' , '>=', UtilHelper::DateToDb(UtilHelper::currentDate())  )
      ->orderBy('id','desc')->paginate(5);


      $nextUrl = '';
      $nextPage = $data->currentPage() == $data->lastPage() ?  '' :  $data->currentPage() + 1;
      if ($nextPage != '') {
        $nextUrl = route('front.search' , [ 'live_search' => $words ] ) . '&page=' . $nextPage;
      }

      if ($request->ajax()) {

          return response()->json(array(
          'status' => 'success',
          'html' => view('components.front.items' , [ 'data' => $data ])->render(),
          'paginate' => $nextUrl ?? view('components.front.paginate' , [ 'nextUrl' => $nextUrl ])->render()   // $data->nextPageUrl()
          )

        );
      };

      return view('front.search', compact(['data','nextUrl']));


  }




}
