<div class="comment-text" id="comment_add_{{$comment->id}}_{{$comment->user_id}}" style="padding-left: 60px;display:none;">
  <img src="assets/images/user_photo.png" class="img-fluid" alt="">
  <div class="form-group">

    <form id="frm_commentadd" name="frm_commentadd" method="post" onsubmit="addComment(event,this,'div_commentadd_{{$comment_id ?? 0}}','err_commentadd_{{$comment_id ?? 0}}')" action="/comment_add" enctype="multipart/form-data"  class="form-inline">
        {{ csrf_field() }}
    		<p class="comment-form-comment">
            <input id="comment" name="comment" maxlength="200" type="text" class="form-control" style="border-radius: 30px;" placeholder="اكتب تعليقا">
    		</p>
    		<p class="form-submit">
    				<input id='item_id' name='item_id' type="hidden" value={{$item->id}}>
    				<input id='comment_type_id' name='comment_type_id' type="hidden" value="1">
    				<input id='parent_id' name='parent_id' type="hidden" value={{$comment_id ?? 0}}>
    				<input name="submit" type="submit" id="submit" class="submit" value="Add {{$title}}" />
    		</p>
    </form>

  </div>
</div>

  <div id="err_commentadd_{{$comment_id ?? 0}}"  name="err_commentadd_{{$comment_id ?? 0}}"></div>
  <div id="div_commentadd_{{$comment_id ?? 0}}"  name="div_commentadd_{{$comment_id ?? 0}}"></div>
