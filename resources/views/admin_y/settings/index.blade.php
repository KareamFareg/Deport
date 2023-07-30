@extends('admin.layouts.master')

@section('content')

<div class="col-xl-6 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.settings.index') }}" :trans="$trans"/>
            </div>
        </h3>
      </div>
      <!-- <div class="kt-portlet__head-toolbar">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#kt_widget11_tab1_content" role="tab">
              Last Month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#kt_widget11_tab2_content" role="tab">
              All Time
            </a>
          </li>
        </ul>
      </div> -->
    </div>



<!-- form -->
<!-- enctype="multipart/form-data" -->
<form class="kt_form_1"  enctype="multipart/form-data" action="{{route('admin.settings.update') }}" method="post">

        <input name="_method" type="hidden" value="PUT">

        {{ csrf_field() }}

        <input type="hidden" value="{{ $trans }}" name="language">

        <div class="kt-portlet__body">

          <!--Begin::Tab Content-->
          <div class="tab-content">

            <!--begin::tab 1 content-->
            <div class="tab-pane active" id="kt_widget11_tab1_content">

              @foreach($settings as $setting)

                  @if($setting->property == 'app_title')
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
                  @endif

                  @if($setting->property == 'facebook')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.facebook') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}" maxlength="500"
                      value="{{ old('facebook',$setting->value) }}" name="facebook" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('facebook'))
                              <span class="invalid-feedback">{{ $errors->first('facebook') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'tweeter')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.tweeter') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('tweeter') ? ' is-invalid' : '' }}" maxlength="500"
                      value="{{ old('tweeter',$setting->value) }}" name="tweeter" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('tweeter'))
                              <span class="invalid-feedback">{{ $errors->first('tweeter') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'instagram')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.instagram') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('instagram') ? ' is-invalid' : '' }}" maxlength="500"
                      value="{{ old('tweeter',$setting->value) }}" name="instagram" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('instagram'))
                              <span class="invalid-feedback">{{ $errors->first('instagram') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'linkedin')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.linkedin') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('linkedin') ? ' is-invalid' : '' }}" maxlength="500"
                      value="{{ old('linkedin',$setting->value) }}" name="linkedin" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('linkedin'))
                              <span class="invalid-feedback">{{ $errors->first('linkedin') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'phone_1')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.phone_1') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('phone_1') ? ' is-invalid' : '' }}" maxlength="100"
                       value="{{ old('phone_1',$setting->value) }}" name="phone_1" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('phone_1'))
                              <span class="invalid-feedback">{{ $errors->first('phone_1') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'mail')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.mail') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('mail') ? ' is-invalid' : '' }}" maxlength="300"
                       value="{{ old('mail',$setting->value) }}" name="mail" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('mail'))
                              <span class="invalid-feedback">{{ $errors->first('mail') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'address')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.address') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" maxlength="500"
                       value="{{ old('address',$setting->value) }}" name="address" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('address'))
                              <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'app_android_lnk')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_android_lnk') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('app_android_lnk') ? ' is-invalid' : '' }}"
                      maxlength="500"
                       value="{{ old('app_android_lnk',$setting->value) }}" name="app_android_lnk" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('app_android_lnk'))
                              <span class="invalid-feedback">{{ $errors->first('app_android_lnk') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'app_ios_link')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_ios_link') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('app_ios_link') ? ' is-invalid' : '' }}"
                      maxlength="500"
                       value="{{ old('app_ios_link',$setting->value) }}" name="app_ios_link" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('app_ios_link'))
                              <span class="invalid-feedback">{{ $errors->first('app_ios_link') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'app_share_note')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_share_note') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('app_share_note') ? ' is-invalid' : '' }}"
                      maxlength="500"
                       value="{{ old('app_share_note',$setting->value) }}" name="app_share_note" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('app_share_note'))
                              <span class="invalid-feedback">{{ $errors->first('app_share_note') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'work_times')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.work_times') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('work_times') ? ' is-invalid' : '' }}"
                      maxlength="500"
                       value="{{ old('work_times',$setting->value) }}" name="work_times" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('work_times'))
                              <span class="invalid-feedback">{{ $errors->first('work_times') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'logo')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.logo') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                      <input type="file" name="logo" id="input-file-now-custom-1" class="dropify"
                      data-default-file="{{ asset('storage/app/'.$setting->value) }}" />
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'agree_conditions1')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('agree_conditions1') ? ' is-invalid' : '' }}"
                          maxlength="500"
                           value="{{ old('agree_conditions1',$setting->value) }}" name="agree_conditions1" placeholder="">
                          <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                          @if ($errors->has('agree_conditions1'))
                                  <span class="invalid-feedback">{{ $errors->first('agree_conditions1') }}</span>
                          @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'agree_conditions2')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('agree_conditions2') ? ' is-invalid' : '' }}"
                          maxlength="500"
                           value="{{ old('agree_conditions2',$setting->value) }}" name="agree_conditions2" placeholder="">
                          <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                          @if ($errors->has('agree_conditions2'))
                                  <span class="invalid-feedback">{{ $errors->first('agree_conditions2') }}</span>
                          @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'agree_conditions3')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('agree_conditions3') ? ' is-invalid' : '' }}"
                          maxlength="500"
                           value="{{ old('agree_conditions3',$setting->value) }}" name="agree_conditions3" placeholder="">
                          <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                          @if ($errors->has('agree_conditions3'))
                                  <span class="invalid-feedback">{{ $errors->first('agree_conditions3') }}</span>
                          @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'car_models')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.car_models') }} *</label>
                    <div class=" col-lg-4 col-md-9 col-sm-12">
                          <input type="number" class="form-control {{ $errors->has('car_models_from') ? ' is-invalid' : '' }}"
                          required maxlength="4"
                           value="{{ old('car_models_from', $setting->value[0]) }}" name="car_models_from" placeholder="">
                          @if ($errors->has('car_models_from'))
                                <span class="invalid-feedback">{{ $errors->first('car_models_from') }}</span>
                          @endif
                          <br>
                          <input type="number" class="form-control {{ $errors->has('car_models_to') ? ' is-invalid' : '' }}"
                          required maxlength="4"
                           value="{{ old('car_models_to',$setting->value[1]) }}" name="car_models_to" placeholder="">
                          @if ($errors->has('car_models_to'))
                                <span class="invalid-feedback">{{ $errors->first('car_models_to') }}</span>
                          @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'agree_contract')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_contract') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('agree_contract') ? ' is-invalid' : '' }}"
                      maxlength="1000"
                       value="{{ old('agree_contract',$setting->value) }}" name="agree_contract" placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('agree_contract'))
                            <span class="invalid-feedback">{{ $errors->first('agree_contract') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'about_us')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.about_us') }}</label>
                    <div class=" col-lg-8 col-md-12 col-sm-12">
                      <textarea name="about_us" class="form-control" data-provide="markdown" rows="10">{{ old('about_us',$setting->value) }}</textarea>
                      @if ($errors->has('about_us',$setting->value))
                            <span class="invalid-feedback">{{ $errors->first('about_us') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'terms')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.terms') }}</label>
                    <div class=" col-lg-8 col-md-12 col-sm-12">
                      <textarea name="terms" class="form-control" data-provide="markdown" rows="10">{{ old('terms',$setting->value) }}</textarea>
                      @if ($errors->has('terms',$setting->value))
                            <span class="invalid-feedback">{{ $errors->first('terms') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif

                  @if($setting->property == 'privacy')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.privacy') }}</label>
                    <div class=" col-lg-8 col-md-12 col-sm-12">
                      <textarea name="privacy" class="form-control" data-provide="markdown" rows="10">{{ old('privacy',$setting->value) }}</textarea>
                      @if ($errors->has('privacy',$setting->value))
                            <span class="invalid-feedback">{{ $errors->first('privacy') }}</span>
                      @endif
                    </div>
                  </div>
                  @endif


                  @if($setting->property == 'lat')
                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.address') }}</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                      <div id="map" style="width: 700px;height: 500px;"></div>
                      @php $lat = $setting->value @endphp
                      <input type="hidden" name="lat" id="lat" value={{ $lat }}>
                    </div>
                  </div>
                  @endif

                @if($setting->property == 'lng')
                @php $lng = $setting->value @endphp
                <input type="hidden" name="lng" id="lng" value={{ $lng }}>
                @endif

              @endforeach

              <x-buttons.but_submit/>

              <!--end::Widget 11-->
            </div>

          </div>

          <!--End::Tab Content-->
        </div>

</form>

  </div>

  <!--end:: Widgets/Sale Reports-->
</div>


@section('js_pagelevel')
  <x-admin.dropify-js/>
  <x-admin.google-map-js :lat="$lat" :lng="$lng"/>
@endsection

@endsection
