<div class="most-commented">
  <div class="card shadow-sm">
    <div class="card-header">
      <h4><i class="fas fa-mobile text-danger"></i> تحميل التطبيقات</h4>
    </div>
    <div class="card-body">
      <p class="text-muted">حمل التطبيقات الآن</p>
      <div class="download-app">
        <a href="{{ $getAppLinks()['app_ios_link'] }}"><img src="{{ asset('assets/front/images/app-store.svg') }}" class="img-fluid" alt=""></a>
        <a href="{{ $getAppLinks()['app_android_lnk'] }}"><img src="{{ asset('assets/front/images/google-play.svg') }}" class="img-fluid" alt=""></a>
      </div>
    </div>
  </div>
</div>
