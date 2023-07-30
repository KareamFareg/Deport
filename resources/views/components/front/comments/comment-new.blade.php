
<div class="card-footer">

@php $currentId = $item->id; @endphp
<div class="comment-text" id="comment_add_{{ $currentId }}" style="padding-right: 10px;display: flex;width: 100%">

  {{--<img src="{{ $item->user ? $item->user->imagePath() : asset('assets/front/images/user_photo.png') }}" class="img-fluid" alt="">--}}
  <img src="{{ auth() ? auth()->user()->imagePath() : asset('assets/front/images/user_photo.png') }}" class="img-fluid" alt="" style="width: 32px;height: 32px;border-radius: 50%;background-clip: padding-box;">

  <div class="form-group">

    <form  method="post" onsubmit="addComment(event,this,'div_commentadd_{{$currentId ?? 0}}','err_commentadd_{{$currentId ?? 0}}')"
    action="{{ route('comments.add') }}" enctype="multipart/form-data"  id="frm_commentadd" name="frm_commentadd" class="form-inline" style="flex-flow: row;">
        {{ csrf_field() }}
    		<p class="comment-form-comment" style="width:88%;">
            <input id="comment" name="comment" maxlength="200" type="text" class="form-control comment" style="border-radius: 30px;width : 99%;" placeholder="اكتب تعليقا">
    		</p>
    		<p class="form-submit">
            <input id='table_id' name='table_id' type="hidden" value={{$item->id}}>
            <input id='table_name' name='table_name' type="hidden" value='items'>
    				<input id='comment_type_id' name='comment_type_id' type="hidden" value="1">
    				<input id='parent_id' name='parent_id' type="hidden" value={{$comment->id ?? 0}}>
            <input id='main_parent_id' name='main_parent_id' type="hidden" value="0">
            <button type="submit" class="btn"><img src="{{ asset('assets/front/images/send.svg') }}" class="img-fluid" alt="icon"></button>
    		</p>
    </form>

  </div>
</div>

</div>

    <div id="err_commentadd_{{$currentId ?? 0}}"  name="err_commentadd_{{$currentId ?? 0}}"></div>
    <div id="div_commentadd_{{$currentId ?? 0}}"  name="div_commentadd_{{$currentId ?? 0}}" style="padding-right: 30px;padding-left: 30px;"></div>
