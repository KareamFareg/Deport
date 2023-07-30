@if (!empty($paginate))
  @if ($paginate['currentPage'] + 1 <= $paginate['lastPage'])
    <div class="more-comments">
      <a href="{{ route('items.comments' , [ 'id' => $itemId , 'page' => $paginate['currentPage']+1 ] ) }}"
        onclick="linkAjaxMore(event,this,'item_comments_{{$itemId}}','item_comments_pagination_{{$itemId}}','err_item_comments_{{$itemId}}')">
        <i class="fas fa-angle-down"></i>{{ $paginate['total'] }} مزيد من التعليقات</a>
      <span></span>
    </div>
  @endif
@else
<div class="more-comments">
  <a href="{{ route('items.comments' , [ 'id' => $itemId ] ) }}"
    onclick="linkAjaxMore(event,this,'item_comments_{{$itemId}}','item_comments_pagination_{{$itemId}}','err_item_comments_{{$itemId}}')">
    <i class="fas fa-angle-down"></i> عرض التعليقات</a>
  <span></span>
</div>
@endif
