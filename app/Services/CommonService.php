<?php

namespace App\Services;
use App\Helpers\UtilHelper;
use App\Models\Item;
use App\Models\ULike;
use Auth;
use Validator;
use Illuminate\Validation\Rule;

class CommonService
{

  public function validateStoreLike($request)
  {

      $validator = Validator::make($request, [
          'table_name' => ['required','string','max:30',Rule::in(['items']) ],
          'table_id' => 'required|integer',
      ]);

      if ($validator->fails()) {
        return $validator;
      }

      return true;

  }

  public function validateDoublicateLike($request)
  {
    return ULike::where([ 'user_id' => $request['user_id'] , 'table_name' => $request['table_name'] , 'table_id' => $request['table_id'] ])->exists();
  }


  public function storeLike($request)
  {
    return ULike::create( $request );
  }

  public function disLike($request)
  {
    return ULike::where([ 'user_id' => $request->user_id , 'table_name' => $request->table_name , 'table_id' => $request->table_id  ])->delete();
  }

  public function getItemLikesCount($itemId)
  {
      return ULike::where([ 'table_name' => 'items' , 'table_id' => $itemId  ])->count();
  }

  public function incrementItemLikes($itemId)
  {
    $item = Item::find($itemId);
    // $item->increment('likes');
    $item->update([ 'likes' => $this->getItemLikesCount($itemId) ]);
    return $item;
  }

  public function decrementItemLikes($itemId)
  {
    $item = Item::find($itemId);
    // $item->decrement('likes');
    $item->update([ 'likes' => $this->getItemLikesCount($itemId) ]);    
    return $item;
  }


  public function incrementItemComments($itemId)
  {
    $item = Item::find($itemId);
    $item->increment('comments');
    return $item;
  }

  public function incrementItemViews($itemId)
  {
    $item = Item::find($itemId);
    $item->increment('views');
    return $item;
  }



}
