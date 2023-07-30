<?php

namespace App\Services;
use App\Models\Rate;
use App\Models\Comment;
use App\Helpers\UtilHelper;
use Illuminate\Support\Facades\DB;

class CommentService
{

  public function store($request)
  {
    return Comment::create( $request );
  }

  public function incementChildsCount($parent_id)
  {
    Comment::find($parent_id)->increment('childs_count');
  }

  public function getCommentsRootOfItem($item_id)
  {
    return Comment::with('user')->where([ 'table_name' => 'items' , 'table_id' => $item_id , 'parent_id' => 0])->orderby('created_at','desc')->paginate(5);
  }

  public function setActive( $comment , $status )
  {
      $comment->update([ 'approved' => $status ]);
  }


}
