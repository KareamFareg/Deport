@extends('front.layouts.master')

@section('content')
<div class="row">

  <div class="col-md-6 offset-md-3">
    <div class="kt-portlet">
      <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid">
          <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
              <div class="card-header">{{ __('verification.enter_code') }}</div>

              <div class="card-body">
                <form method="POST" action="{{ route('admin.verifications.check') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <!-- <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('verification.enter_code') }}</label> -->
                        <div class="col-md-3">
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $code) }}" maxlength="10" required  autofocus>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-0">
                        <div class="col-md-3 offset-md-9">
                            <button type="submit" class="btn btn-primary">
                                {{ __('verification.verify') }}
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
