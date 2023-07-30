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

        <x-Front.OuterStatments/>

        <div class="col-md-7 col-sm-6 col-xs-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="login-form">
                <div class="login-user-icon">
                  <img src="{{ asset('assets/front/images/add-user.svg') }}" class="img-fluid mx-auto" alt="">
                  <h1 class="login-title">{{ __('auth.login') }}</h1>
                </div>

                  <x-FlashAlert/>


                  <form method="POST" action="{{ route('front.login') }}" enctype="multipart/form-data">
                      @csrf


                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required maxlength="10" name="phone" value="{{ old('phone') }}" placeholder="{{ __('words.phone') }}">
                      @error('phone')
                          <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
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


                  <div class="form-option">
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">تذكرني</label>
                    </div>
                    <div class="space"></div>
                    <div class="remember-me">
                      <a href="{{ route('password.reset') }}">هل نسيت كلمة المرور ؟</a>
                    </div>
                  </div>


                  <div class="submit-btn">
                    <button type="submit" class="btn btn-block btn-danger shadow">
                        {{ __('auth.login') }}
                    </button>
                  </div>
                </form>

                <div class="create-account">
                  <a href="{{ route('front.register') }}" class="btn btn-default btn-block btn-rounded">انشاء حساب جديد</a>
                </div>

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
