<header class="main-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12">

        <x-logos.logo/>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="search">
          <div class="search-box">
            <form action="{{ route('front.search') }}" method="get">
              <div class="form-group">
                <input type="text" id="live_search" name="live_search" class="typeahead form-control" value="{{ request()->live_search ?? '' }}" placeholder="عن ماذا تبحث">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-12">
        <div class="user-links">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i style="width: 50px;overflow: hidden;display: inline-flex;">{{ auth()->user()->name }}</i> <i class="fas fa-user-circle"></i>
            </button>
            <div class="dropdown-menu animate slideIn" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{ route('user.profile', [ 'id' => auth()->id() ]) }}"><i class="fas fa-user"></i> بياناتي الشخصية</a>
              <a class="dropdown-item" href="{{ route('user.offers', [ 'id' => auth()->id() ]) }}"><i class="fas fa-tags"></i> عروضي</a>
              <a class="dropdown-item" href="{{ route('user.coupons', [ 'id' => auth()->id() ]) }}"><i class="fas fa-ticket-alt"></i> كوبوناتي</a>
              <a class="dropdown-item" href="{{ route('user.likes', [ 'id' => auth()->id() ]) }}"><i class="far fa-heart"></i> اعجاباتي</a>
              <a class="dropdown-item" href="{{ route('user.comments', [ 'id' => auth()->id() ]) }}"><i class="far fa-comment"></i> تعليقاتي </a>
              <a class="dropdown-item" href="{{ route('user.images', [ 'id' => auth()->id() ]) }}"><i class="fas fa-images"></i> البوم الصور</a>
              <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                      <i class="fas fa-power-off"></i>{{ __('auth.logout') }}</a>
              <form id="logout-form" action="{{ route('front.logout') }}" method="POST" style="display: none;">
                      @csrf
              </form>
            </div>
          </div>

          <x-pusher.notify/>
          <!-- <div class="notifications">
          </div>
          <div class="likes">
            <a href="" class="btn btn-secondary">
               <span class="badge">0</span> <i class="far fa-heart"></i>
            </a>
          </div> -->

          <div class="share-now">
            <a href="" class="btn btn-warning"><img src="{{ asset('assets/front/images/btn-img.svg') }}" alt=""> شارك</a>
          </div>
        </div>

      </div>
    </div>

  </div>
</header>
