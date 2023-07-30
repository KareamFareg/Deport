<div class="main-single-comment">
  <div class="media">
    <div class="media-left">
      <!-- <img src="assets/images/user_photo.png" alt=""> -->
      <img src="{{ $comment->user ? $comment->user->imagePath() : asset('assets/front/images/user_photo.png') }}"
      style="width: 32px;height: 32px;border-radius: 50%;background-clip: padding-box;"
      class="img-fluid" alt="">
    </div>
    <div class="media-body">
      <p>
        <b>
          <a href="{{ route('user.profile' , [ 'id' => $comment->user_id ] ) }}">
            {{ optional($comment->user)->name }}</a>
       </b>

       <!-- display parent comment user (mention) -->
       @php
        $parent_comment = \App\Models\Comment::find($comment->parent_id);
        $parent_user = null;
        if ($parent_comment) {
          $parent_user = \App\User::find($parent_comment->user_id);
        }
       @endphp

       @if ($parent_user)
          <a href="{{ route('user.profile' , [ 'id' => $parent_user->id ] ) }}" > {{ $parent_user->name }}</a>
       @endif


       {{ $comment->comment}}
      </p>
      <div class="comment-info">
        <div class="comment-date">
          {{ $comment->created_at }}
        </div>
        <!-- <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button> -->
        <button onclick="ShowHideReplay('comment_add_{{$comment->id}}_{{$comment->user_id}}')" type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>


        <!-- if we want tree check this -->{{--
        @if ($comment->childs_count)
        <form id="frm_comment_get_{{ $comment->id }}" name="frm_comment_get_{{ $comment->id }}" method="get"
            onsubmit="formAjax(event,this,'comment_childs_{{$comment->id}}','err_comment_childs_{{$comment->id}}')"
            action="{{ route('comments.childs', [ 'id' =>  $comment->id ] ) }}" class="form-inline">
            {{ csrf_field() }}
            <input type="hidden" name="params[parent_id]" id="params[parent_id]" value="{{$comment->id}}" />
            <input type="hidden" name="pg" id="pg" value=null />
            <input type="submit" class="button" name="track" value="الردود {{$comment->childs_count}}"  />
        </form>
        @endif
        --}}<!--  -->

        <!--  if we want only parnet and only one level check commant parent_id -->
        @if ($comment->childs_count && $comment->parent_id == 0)
        <form id="frm_comment_get_{{ $comment->id }}" name="frm_comment_get_{{ $comment->id }}" method="get"
            onsubmit="formAjax(event,this,'comment_childs_{{$comment->id}}','err_comment_childs_{{$comment->id}}')"
            action="{{ route('comments.childs', [ 'id' =>  $comment->id ] ) }}" class="form-inline">
            {{ csrf_field() }}
            <input type="hidden" name="params[parent_id]" id="params[parent_id]" value="{{$comment->id}}" />
            <input type="hidden" name="pg" id="pg" value=null />
            <input type="submit" class="button" name="track" value="الردود {{$comment->childs_count}}"  />
        </form>
        @endif


      </div>
    </div>
  </div>
</div>




<!-- add -->
<!-- <div class="write-comment" id=""> -->
<x-front.comments.comment-add :comment="$comment"/>

<!-- div for show Replay -->
<div class="comment-text" id="err_comment_childs_{{$comment->id}}" style="padding-right: 30px"></div>
<div class="comment-text" id="comment_childs_{{$comment->id}}" style="{{ $comment->parent_id == 0 ? 'padding-right: 30px' : '' }}"></div>



<script type="text/javascript">
function ShowHideReplay(replay_div) {
  var x = document.getElementById(replay_div);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
