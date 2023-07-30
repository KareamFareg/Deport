<div class="most-commented">
  <div class="card shadow-sm">
    <div class="card-header">
      <h4><i class="fas fa-comment text-warning"></i>{{ __('words.most_'.$currentMost) }}</h4>
    </div>


    <div class="card-body">
      <ul class="list-unstyled no-margin">
        @foreach($getTheMost as $item)
        <li>
          <div class="side-widget">
            <div class="media">
              <div class="media-left">
                <a href="{{ route('user.profile', [ 'id' => $item->user->id ] ) }}"><img src="{{ $item->user->imagePath() }}" alt=""></a>
              </div>
              <div class="media-body">
                <div class="media-heading">
                  <div class="widget-title">
                    <h5><a href="{{ route('user.profile' , [ 'id' => $item->user->id ] ) }}">
                      {{ $item->user ? $item->user->name : '' }}</a>
                    </h5>{{-- optional($item->user->client->client_info->first())->title --}}
                    <span>{{ $item->created_at }}</span>
                  </div>
                  <div class="space"></div>
                  <div class="widget-comments">
                    <span class="badge badge-pill badge-light"><i class="fas fa-comment"></i>{{ $item->comments }}</span>
                  </div>
                </div>
                <div class="media-text">
                  <a href="{{ route('items.show', [ 'id' => $item->id ] ) }}">
                    <p>{{ optional($item->item_info->first())->description }}</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>
        @endforeach

      </ul>
    </div>
  </div>
</div>
