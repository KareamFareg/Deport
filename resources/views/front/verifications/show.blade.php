<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>سنارة</title>
  <!-- styles CSS -->
  <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
  <title></title>
</head>

<body class="rtl-mode">
  <section id="wrapper">
    <div class="login-page">
      <div class="row">
        <div class="col-md-5 col-sm-6 col-xs-12">
          <div class="signup-bg">
            <div class="l-logo">
              <img src="{{ asset('assets/front/images/logo.svg') }}" alt="">
            </div>
            <ul class="list-unstyled no-margin">
              <li><img src="assets/images/login-icon-1.svg" class="img-fluid" alt="icon"> تعرف علي مايحدث في عالم العروض والتخفيضات الآن</li>
              <li><img src="assets/images/login-icon-2.svg" class="img-fluid" alt="icon"> لاتفوت اهم التخفيضات والكوبونات الحصرية</li>
              <li><img src="assets/images/login-icon-3.svg" class="img-fluid" alt="icon"> دليلك لاحدث الكوبونات وعروض الخصم</li>
            </ul>
          </div>
        </div>
        <div class="col-md-7 col-sm-6 col-xs-12">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <div class="login-form">
                <div class="login-user-icon">
                  <img src="assets/images/sms.png" class="img-fluid mx-auto" alt="">
                  <h1 class="login-title">{{ __('verification.enter_code') }}</h1>
                  <p class="text-dark mt-3 mb-0">تم ارسال كود التحقق في رسالة sms علي جوالك</p>
                </div>

                <x-FlashAlert/>

                <form method="POST" action="{{ route('front.verifications.check') }}" enctype="multipart/form-data">
                    @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $code) }}" maxlength="10" required placeholder="ادخل كود التحقق"  autofocus>
                      @error('code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>

                  <div class="submit-btn">
                    <button type="submit" class="btn btn-block btn-danger shadow" data-toggle="modal" data-target="#success">
                        {{ __('verification.verify') }}
                    </button>
                  </div>

                </form>


                  <div class="create-account">
                    <form action="{{ route('front.verifications.resend_code') }}" method="post">
                      @csrf
                      <p class="text-dark">لم يصلك الكود ؟
                        {{-- <a href="{{ route('password.resend_code') }}">اعادة الارسال</a>--}}
                        <button type="submit" class="btn btn-block btn-danger shadow">اعادة الارسال</button>
                      </p>
                    </form>
                  </div>

                  <!-- <div class="resend-code text-center">
                    <span class="btn btn-danger bg-white text-danger"><i class="fas fa-clock"></i> بعد ٣٠ ثانية </span>
                  </div> -->


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade success-regsiter" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <span></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="msg d-flex align-items-center justify-content-center flex-column">
              <img src="assets/images/done.svg" class="img-fluid mb-5" alt="">
              <h1 class="font-weight-bold text-success mb-4">تهانينا !</h1>
              <h4 class="font-weight-bold text-dark mb-4">لقد تم تفعيل حسابك بنجاح</h4>

              <a href="" class="btn btn-success btn-rounded shaow no-border">حسنا</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>


  <script src="{{ asset('assets/front/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('assets/front/js/popper.js') }}"></script>
  <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/front/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/front/plugins/select2.full.min.js') }}"></script>
  <script src="{{ asset('assets/front/plugins/jssocials.min.js') }}"></script>
  <script src="{{ asset('assets/front/js/scripts.0.0.1.js') }}"></script>
</body>

</html>
