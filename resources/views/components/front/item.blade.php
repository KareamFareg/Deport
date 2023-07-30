
<div class="single-post">
  <div class="card shadow-sm">
    <div class="card-header">
      <div class="media">
        <div class="media-left ml-1">
          <a href="{{ route('user.profile' , [ 'id' => $item->user->id ] ) }}">
            <img src="{{ $item->user->imagePath() }}" class="img-fluid" alt="">
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><a href="{{ route('user.profile' , [ 'id' => $item->user->id ] ) }}">
            {{ $item->user ? $item->user->name : '' }}</a></h4>
          <span><i class="far fa-calendar-alt"></i>
            <a href="{{ route('items.show', [ 'id' => $item->id ] ) }}">
              {{ $item->created_at }}</a>
          </span>
        </div>
      </div>

      @isset($auth)
      @if($item->user_id == auth()->id())
        <div class="post__actions">
          <a href="{{ route('items.edit' , [ 'id' => $item->id ] ) }}" class="btn btn-success btn-rounded"><i class="fas fa-edit"></i> <span class="text-dark">تعديل</span></a>
           <form  method="post" onsubmit="showConfirmation(event,this)" action="{{ route('items.delete' , [ 'id' => $item->id ] ) }}" class="form-inline">
              {{ csrf_field() }}
              <input type="hidden" name="redir"  id="redir" value="redir">
              <button  type="submit" class="btn btn-link mr-2"><i class="fas fa-trash-alt text-danger"></i> <span class="text-dark">حذف</span></button>
          </form>
        </div>
      @endif
      @endisset

      @if ($item->type_id == 1)
      <div class="s-post-type bg-danger">
        <img src="{{ asset('assets/front/images/discount-2.svg') }}" class="img-fluid" alt="">
        <span>{{ $item->item_type->title }}</span>
      </div>
      @endif
      @if ($item->type_id == 2)
      <div class="s-post-type bg-warning">
        <img src="{{ asset('assets/front/images/coupon-2.svg') }}" class="img-fluid" alt="">
        <span>{{ $item->item_type->title }}</span>
      </div>
      @endif

    </div>
    <div class="card-body">
      <p class="card-text">{{ optional($item->item_info->first())->description }}</p>
      @if (!$item->files->isEmpty())
        <div class="post-imgs">
          <div class="row">

            <div class="col-6 col-padding-5">
              @foreach($item->files as $file)
                @if($loop->iteration <= 2)
                      <div class="sm-thum">
                        <img src="{{ $file->filePath() }}" class="img-fluid enlarge" alt="" onclick="enlarge(this)">
                      </div>
                @endif
              @endforeach
            </div>
            <div class="col-6 col-padding-5">
              @foreach($item->files as $file)
                @if($loop->iteration == 3)
                  <div class="lg-img">
                    <img src="{{ $file->filePath() }}" class="img-fluid enlarge" alt=""  onclick="enlarge(this)">
                  </div>
                @endif
              @endforeach
            </div>

          </div>
        </div>
      @endif

      @if ($item->links)
      <div class="post-link">
        <a href="{{ $item->links }}" target="_blank" class="alert alert-success" role="alert">
          <i class="fas fa-link"></i>{{ $item->links }}
        </a>
      </div>
      @endif
      <div class="post-counts">
        <span class="text-warning"><span id='comments_count_{{$item->id}}'></span>{{ $item->comments }}<i class="fas fa-comment"></i></span>
        <span class="text-danger"><span id='likes_count_{{$item->id}}'>{{ $item->likes }}</span><i class="fas fa-heart"></i></span>
        <span class="text-muted"><span id='views_count_{{$item->id}}'>{{ $item->views }}</span><i class="fas fa-eye"></i></span>
      </div>


      <div class="post-actions">
        <div class="like">
          <form  method="post" onsubmit="addLike(event,this,'likes_count_{{$item->id}}','err_comments_count_{{$item->id}}')" action="{{ route('items.like') }}">
              {{ csrf_field() }}
                <input id='table_id' name='table_id' type="hidden" value={{$item->id}}>
                <input id='table_name' name='table_name' type="hidden" value='items'>
                <button class="btn" type="submit">
                   <div>
                    <input type="checkbox" class="checkbox" id="checkbox{{$item->id}}" />
                    <label for="checkbox{{$item->id}}">
                        <svg class="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                              <g class="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" class="heart" fill="#cb0621"/>
                                <circle class="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>

                                <g class="grp7" opacity="0" transform="translate(7 6)">
                                  <circle class="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                  <circle class="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                </g>

                                <g class="grp6" opacity="0" transform="translate(0 28)">
                                  <circle class="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                  <circle class="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                </g>

                                <g class="grp3" opacity="0" transform="translate(52 28)">
                                  <circle class="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                  <circle class="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                </g>

                                <g class="grp2" opacity="0" transform="translate(44 6)">
                                  <circle class="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                  <circle class="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                </g>

                                <g class="grp5" opacity="0" transform="translate(14 50)">
                                  <circle class="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                  <circle class="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                </g>

                                <g class="grp4" opacity="0" transform="translate(35 50)">
                                  <circle class="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                  <circle class="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                </g>

                                <g class="grp1" opacity="0" transform="translate(24)">
                                  <circle class="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                  <circle class="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                </g>
                              </g>
                            </svg>
                    </label>
                  </div> اعجبني
                </button>
            </form>
        </div>

        <div class="comments">
            {{--<button class="btn" type='submit'><i class="fas fa-comment"></i>{{ $item->comments }} تعليق</button>--}}
            <span class="btn" style="cursor: auto !important;"><i class="fas fa-comment"></i>{{ $item->comments }} تعليق</span>
        </div>

        <div class="share">
          <x-social-buts shareUrl="{{ route('items.show' , ['id' => $item->id ] ) }}"/>
          <!-- <button class="btn" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-share-alt"></i> مشاركة</button> -->
        </div>

      </div>
    </div>



    <x-front.comments.comment-new :item="$item"/>

    <!-- all comments -->
    @if ($item->comments)
    <div class="post-comments" id="item_comments_{{$item->id}}">
        <x-front.comments.comments :comments="$comments ?? []"/>
    </div>
    <div class="post-comments" id="item_comments_pagination_{{$item->id}}">

        <x-front.comments.comments-paginate :paginate="$paginate ?? []" :itemId="$item->id"/>
    </div>
    @endif


  </div>
</div>
