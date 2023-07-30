<div class="main-single-comment">
  <div class="media">
    <div class="media-left">
      <img src="assets/images/user_photo.png" alt="">
    </div>
    <div class="media-body">
      <p><b>mohammed ahmed ali</b>{{ $comment->comment}}</p>
      <div class="comment-info">
        <div class="comment-date">
          {{ $comment->created_at }}
        </div>
        <!-- <button type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button> -->
        <button onclick="ShowHideReplay('comment_add_{{$comment->id}}_{{$comment->user_id}}')" type="button" class="btn reply-btn">رد <i class="fas fa-reply-all"></i></button>
      </div>
    </div>
  </div>
</div>




<!-- add -->
<!-- <div class="write-comment" id=""> -->
<x-front.comments.comment-add :comment="$comment" :item="$item"/>





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
