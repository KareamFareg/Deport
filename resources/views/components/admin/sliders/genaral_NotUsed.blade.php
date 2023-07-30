<div class="form-group row">
  <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_title') }}</label>
  <div class=" col-lg-7 col-md-9 col-sm-12">
    <input type="text" class="form-control {{ $errors->has('app_title') ? ' is-invalid' : '' }}" required maxlength="100"
    value="{{ old('title',$setting->value) }}" name="app_title" placeholder="">
    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
    @if ($errors->has('app_title'))
            <span class="invalid-feedback">{{ $errors->first('app_title') }}</span>
    @endif
  </div>
</div>
