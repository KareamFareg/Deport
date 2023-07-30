<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <!-- isset($user)  in case of item edit : the request()->id is item id not user id so only in item edit we pass user to get user id here  -->
  <ul class="navbar-nav mr-auto">
    <li class="nav-item {{ ($page == 'profile') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.profile' , ['id' => isset($user) ? $user->id : request()->id ] ) }}">بياناتي الشخصية</a>
    </li>
    <li class="nav-item {{ ($page == 'offers') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.offers' , ['id' => isset($user) ? $user->id : request()->id ] ) }}">عروضي</a>
    </li>
    <li class="nav-item {{ ($page == 'coupons') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.coupons' , ['id' => isset($user) ? $user->id : request()->id ] ) }}">كوبوناتي</a>
    </li>
    {{--@if($auth == true)--}}
    <li class="nav-item {{ ($page == 'likes') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.likes' , ['id' => isset($user) ? $user->id : request()->id] ) }}">اعجاباتي</a>
    </li>
    <li class="nav-item {{ ($page == 'comments') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.comments' , ['id' => isset($user) ? $user->id : request()->id ] ) }}">تعليقاتي</a>
    </li>
    {{--@endif--}}
    <li class="nav-item {{ ($page == 'images') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('user.images' , ['id' => isset($user) ? $user->id : request()->id ] ) }}">البوم الصور</a>
    </li>
  </ul>
</div>
