@extends('util.master')

@section('content')
<div class="row">

  <div class="col-md-6 offset-md-3">
    <h3>{{ __('auth.reset_password') }}</h3>
    <div class="kt-portlet">
      <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid">
          <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
              <div class="card-header">{{ __('passwords.enter_email') }}</div>

              <div class="card-body">
                <form method="POST" action="{{ route('password.email.send') }}">
                    @csrf
                    <div class="form-group row">
                        <!-- <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('verification.enter_code') }}</label> -->
                        <div class="col-md-7">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" maxlength="50" required  autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-2 offset-md-7">
                            <button type="submit" class="btn btn-primary">
                                {{ __('words.send') }}
                            </button>
                        </div>
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
