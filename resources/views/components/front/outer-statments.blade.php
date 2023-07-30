<div class="col-md-5 col-sm-6 col-xs-12">
  <div class="signup-bg">
    <div class="l-logo">
      <img src="{{ asset('assets/images/logo.svg') }}" alt="">
    </div>

    <x-logos.logo/>

    <ul class="list-unstyled no-margin">
      @if ($getStatments()['register_st_1'])
      <li><img src="{{ asset('assets/front/images/login-icon-1.svg') }}" class="img-fluid" alt="icon"> {{ $getStatments()['register_st_1'] }} </li>
      @endif
      @if ($getStatments()['register_st_2'])
      <li><img src="{{ asset('assets/front/images/login-icon-2.svg') }}" class="img-fluid" alt="icon"> {{ $getStatments()['register_st_2'] }} </li>
      @endif
      @if ($getStatments()['register_st_3'])
      <li><img src="{{ asset('assets/front/images/login-icon-3.svg') }}" class="img-fluid" alt="icon"> {{ $getStatments()['register_st_3'] }} </li>
      @endif
    </ul>
  </div>
</div>
