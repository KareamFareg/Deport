
    @foreach ($comments as $comment)
      <x-front.comments.comment-row :comment="$comment"/>
    @endforeach
