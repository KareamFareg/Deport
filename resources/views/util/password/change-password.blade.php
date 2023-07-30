@extends('util.master')

@section('content')
<div class="row">

  <div class="col-md-6 offset-md-3">
    <h3>{{ __('auth.reset_password') }}</h3>
    <div class="kt-portlet">
      <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid">
          <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
              <div class="card-header">{{ __('auth.change_password') }}</div>

              <div class="card-body">

                  <form action="{{ route('password.email.change_password') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $verifyToken->token }}"/>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control" required minlength="8" maxlength="12" placeholder="ادخل كلمة المرور">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="8" maxlength="12" placeholder="اعادة كلمة المرور">
                      </div>
                    </div>
                    <div class="submit-btn">
                      <button class="btn btn-block btn-danger shadow">حفظ</button>
                    </div>

                  </form>

              </div>
          </div>
        </div>
      </div>
    </div>
</div>

</div>
@endsection
