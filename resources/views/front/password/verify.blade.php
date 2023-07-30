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
            <div class="col-lg-8 offset-lg-2">
              <div class="login-form">
                <div class="login-user-icon">
                  <img src="{{ asset('assets/images/sms.png') }}" class="img-fluid mx-auto" alt="">
                  <h1 class="login-title">ادخال كود التحقق</h1>
                  <p class="text-dark mt-3 mb-0">تم ارسال كود التحقق في رسالة sms علي جوالك</p>
                </div>

                <x-FlashAlert/>

                <form action="{{ route('password.verify') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" name="code" value="{{ $code ?? '' }}" class="form-control" placeholder="ادخل كود التحقق" required>
                    </div>
                  </div>

                  <div class="submit-btn">
                    <button type="submit" class="btn btn-block btn-danger shadow">تاكيد</button>
                  </div>
                </form>

                
                  <div class="create-account">
                    <form action="{{ route('password.resend_code') }}" method="post">
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
