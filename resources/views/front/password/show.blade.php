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
                  <img src="{{ asset('assets/front/images/account.svg') }}" class="img-fluid mx-auto" alt="">
                  <h1 class="login-title">رقم جوالك</h1>
                  <p class="text-dark mt-3 mb-0">فضلا قم بكتابة رقم جوالك المسجل لدينا</p>
                  <x-FlashAlert/>
                </div>
                <form action="{{ route('password.reset') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="ادخل رقم جوالك" required maxlength="9">
                    </div>
                  </div>

                  <div class="submit-btn">
                    <button type="submit" class="btn btn-block btn-danger shadow">ارسال</button>
                  </div>
                </form>

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
