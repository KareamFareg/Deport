<nav class="navbar navbar-expand-lg main-nav shadow-sm">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
  </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item  @isset($page) {{ $page=='item' ? 'active' : '' }} @endisset">
          <a class="nav-link" href="{{ route('front.home') }}"><img src="{{ asset('assets/front/images/select-all.svg') }}" class="img-fluid" alt="icon"> عرض الكل</a>
        </li>
        <li class="nav-item @isset($page) {{ $page=='offers' ? 'active' : '' }} @endisset">
          <a class="nav-link" href="{{ route('front.offers') }}"><img src="{{ asset('assets/front/images/discount.svg') }}" class="img-fluid" alt="icon"> عروض</a>
        </li>
        <li class="nav-item @isset($page) {{ $page=='coupons' ? 'active' : '' }} @endisset">
          <a class="nav-link" href="{{ route('front.coupons') }}"><img src="{{ asset('assets/front/images/coupon.svg') }}" class="img-fluid" alt="icon">كوبونات</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
