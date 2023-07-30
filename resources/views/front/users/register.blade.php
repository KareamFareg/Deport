<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>سنارة</title>
  <!-- styles CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
</head>

<body class="rtl-mode">
  <section id="wrapper">
    <div class="login-page">
      <div class="row">
        <div class="col-md-5 col-sm-6 col-xs-12">

          <x-Front.OuterStatments/>

        </div>
        <div class="col-md-7 col-sm-6 col-xs-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="login-form">
                <div class="login-user-icon">
                  <img src="{{ asset('assets/front/images/add-user.svg') }}" class="img-fluid mx-auto" alt="">
                  <h1 class="login-title">{{ __('auth.register') }}</h1>
                </div>

                  <x-FlashAlert/>


                  <form method="POST" action="{{ route('front.register') }}" enctype="multipart/form-data">
                      @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="اسم المستخدم"
                      name="name" value="{{ old('name') }}" maxlength="150" required autocomplete="name" autofocus>
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>




                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required maxlength="10" name="phone" value="{{ old('phone') }}" placeholder="{{ __('words.mobile') }}">
                      @error('phone')
                          <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="{{ __('words.email') }}">
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                      </div>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                      minlength="6" maxlength="12" required autocomplete="new-password" placeholder="{{ __('words.password') }}" >
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                      </div>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="8" maxlength="12" required autocomplete="new-password" placeholder="{{ __('auth.confirm_password') }}">
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>



                  <div class="form-option">
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="accept_terms" name="accept_terms">
                      <label class="form-check-label" for="exampleCheck1"> اوافق علي <a href="">الشروط والاحكام</a></label>
                      @error('accept_terms')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>

                  </div>
                  <div class="submit-btn">
                    <button type="submit" class="btn btn-block btn-danger shadow">
                        {{ __('auth.register') }}
                    </button>
                  </div>
                </form>

                <div class="create-account">
                  <p class="text-dark">هل لديك حساب بالفعل ؟ <a href="{{ route('front.login') }}">سجل دخول الآن</a></p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/plugins/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/plugins/select2.full.min.js"></script>
  <script src="assets/plugins/jssocials.min.js"></script>
  <script src="assets/js/scripts.0.0.1.js"></script>
</body>

</html>
