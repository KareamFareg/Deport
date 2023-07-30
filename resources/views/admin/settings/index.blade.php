@extends('admin.layouts.master')

@section('content')

    <div class="col-xl-12 col-lg-12">

        <!--begin:: Widgets/Sale Reports-->
        <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <div class="row">
                             
                            <x-admin.trans-bar :languages="$languages" route="{{ route('admin.settings.index') }}"
                                :trans="$trans" />
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
            <form class="kt_form_1" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}"
                method="post">

                <input name="_method" type="hidden" value="PUT">

                {{ csrf_field() }}

                <input type="hidden" value="{{ $trans }}" name="language">

                <div class="kt-portlet__body">

                    <!--Begin::Tab Content-->
                    <div class="tab-content">

                        <!--begin::tab 1 content-->
                        <div class="tab-pane active" id="kt_widget11_tab1_content">



                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_title') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('app_title') ? ' is-invalid' : '' }}" required
                                        maxlength="100" value="{{ old('title', $settings['app_title']) }}"
                                        name="app_title[{{ $trans }}]" placeholder="{{ __('setting.app_title') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('app_title'))
                                        <span class="invalid-feedback">{{ $errors->first('app_title') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.addition_service_cost') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="number"
                                        class="form-control {{ $errors->has('addition_service_cost') ? ' is-invalid' : '' }}" required
                                        maxlength="100" value="{{ old('title', $settings['addition_service_cost']) }}"
                                        name="addition_service_cost" placeholder="{{ __('setting.addition_service_cost') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('addition_service_cost'))
                                        <span class="invalid-feedback">{{ $errors->first('addition_service_cost') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.commission_percent') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="number"
                                        class="form-control {{ $errors->has('commission_percent') ? ' is-invalid' : '' }}" required
                                        maxlength="100" value="{{ old('title', $settings['commission_percent']) }}"
                                        name="commission_percent" placeholder="{{ __('setting.commission_percent') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('commission_percent'))
                                        <span class="invalid-feedback">{{ $errors->first('commission_percent') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.minimum_shipping') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="number"
                                        class="form-control {{ $errors->has('minimum_shipping') ? ' is-invalid' : '' }}" required
                                        maxlength="100" value="{{ old('title', $settings['minimum_shipping']) }}"
                                        name="minimum_shipping" placeholder="{{ __('setting.minimum_shipping') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('minimum_shipping'))
                                        <span class="invalid-feedback">{{ $errors->first('minimum_shipping') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.geofire_radius') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="number"
                                        class="form-control {{ $errors->has('geofire_radius') ? ' is-invalid' : '' }}" required
                                        maxlength="100" value="{{ old('title', $settings['geofire_radius']) }}"
                                        name="geofire_radius" placeholder="{{ __('setting.geofire_radius') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('geofire_radius'))
                                        <span class="invalid-feedback">{{ $errors->first('geofire_radius') }}</span>
                                    @endif
                                </div>
                            </div>

                            



                            {{-- <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.register_st_1') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('register_st_1') ? ' is-invalid' : '' }}"
                                        maxlength="200" value="{{ old('title', $settings['register_st_1']) }}"
                                        name="register_st_1[{{ $trans }}]" placeholder="{{ __('setting.register_st_1') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('register_st_1'))
                                        <span class="invalid-feedback">{{ $errors->first('register_st_1') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.register_st_2') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('register_st_2') ? ' is-invalid' : '' }}"
                                        maxlength="200" value="{{ old('title', $settings['register_st_2']) }}"
                                        name="register_st_2[{{ $trans }}]" placeholder="{{ __('setting.register_st_2') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('register_st_2'))
                                        <span class="invalid-feedback">{{ $errors->first('register_st_2') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.register_st_3') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('register_st_3') ? ' is-invalid' : '' }}"
                                        maxlength="200" value="{{ old('title', $settings['register_st_2']) }}"
                                        name="register_st_3[{{ $trans }}]" placeholder="{{ __('setting.register_st_3') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('register_st_3'))
                                        <span class="invalid-feedback">{{ $errors->first('register_st_3') }}</span>
                                    @endif
                                </div>
                            </div> --}}



                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.facebook') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('facebook', $settings['facebook']) }}" name="facebook"
                                        placeholder="{{ __('setting.facebook') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('facebook'))
                                        <span class="invalid-feedback">{{ $errors->first('facebook') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.tweeter') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('tweeter') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('tweeter', $settings['tweeter']) }}" name="tweeter"
                                        placeholder="{{ __('setting.tweeter') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('tweeter'))
                                        <span class="invalid-feedback">{{ $errors->first('tweeter') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.instagram') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('tweeter', $settings['instagram']) }}"
                                        name="instagram" placeholder="{{ __('setting.instagram') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('instagram'))
                                        <span class="invalid-feedback">{{ $errors->first('instagram') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.linkedin') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('linkedin') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('linkedin', $settings['linkedin']) }}" name="linkedin"
                                        placeholder="{{ __('setting.linkedin') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('linkedin'))
                                        <span class="invalid-feedback">{{ $errors->first('linkedin') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.snapchat') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('snapchat') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('snapchat', $settings['snapchat']) }}" name="snapchat"
                                        placeholder="{{ __('setting.snapchat') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('snapchat'))
                                        <span class="invalid-feedback">{{ $errors->first('snapchat') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.website') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('website', $settings['website']) }}" name="website"
                                        placeholder="{{ __('setting.website') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback">{{ $errors->first('website') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.telegram') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('telegram') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('telegram', $settings['telegram']) }}" name="telegram"
                                        placeholder="{{ __('setting.telegram') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('telegram'))
                                        <span class="invalid-feedback">{{ $errors->first('telegram') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.phone_1') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('phone_1') ? ' is-invalid' : '' }}"
                                        maxlength="100" value="{{ old('phone_1', $settings['phone_1']) }}" name="phone_1"
                                        placeholder="{{ __('setting.phone_1') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('phone_1'))
                                        <span class="invalid-feedback">{{ $errors->first('phone_1') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.UPhone') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('UPhone') ? ' is-invalid' : '' }}"
                                        maxlength="100" value="{{ old('UPhone', $settings['UPhone']) }}" name="UPhone"
                                        placeholder="{{ __('setting.UPhone') }}">
                                    @if ($errors->has('UPhone'))
                                        <span class="invalid-feedback">{{ $errors->first('UPhone') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            <!-- <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.CRMPhone') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('CRMPhone') ? ' is-invalid' : '' }}"
                                        maxlength="100" value="{{ old('CRMPhone', $settings['CRMPhone']) }}" name="CRMPhone"
                                        placeholder="{{ __('setting.CRMPhone') }}">
                                    @if ($errors->has('CRMPhone'))
                                        <span class="invalid-feedback">{{ $errors->first('CRMPhone') }}</span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.CRMPhone') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('customer_service') ? ' is-invalid' : '' }}"
                                        maxlength="100" value="{{ old('customer_service', $settings['customer_service']) }}" name="customer_service"
                                        placeholder="{{ __('setting.customer_service') }}">
                                    @if ($errors->has('customer_service'))
                                        <span class="invalid-feedback">{{ $errors->first('customer_service') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            
                            
                            

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.mail') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text" class="form-control {{ $errors->has('mail') ? ' is-invalid' : '' }}"
                                        maxlength="300" value="{{ old('mail', $settings['mail']) }}" name="mail"
                                        placeholder="{{ __('setting.mail') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('mail'))
                                        <span class="invalid-feedback">{{ $errors->first('mail') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.address') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('address', $settings['address']) }}" name="address"
                                        placeholder="{{ __('setting.address') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_android_lnk') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('app_android_lnk') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('app_android_lnk', $settings['app_android_lnk']) }}"
                                        name="app_android_lnk" placeholder="{{ __('setting.app_android_lnk') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('app_android_lnk'))
                                        <span class="invalid-feedback">{{ $errors->first('app_android_lnk') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_ios_link') }}</label>
                                <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control {{ $errors->has('app_ios_link') ? ' is-invalid' : '' }}"
                                        maxlength="500" value="{{ old('app_ios_link', $settings['app_ios_link']) }}"
                                        name="app_ios_link" placeholder="{{ __('setting.app_ios_link') }}">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                    @if ($errors->has('app_ios_link'))
                                        <span class="invalid-feedback">{{ $errors->first('app_ios_link') }}</span>
                                    @endif
                                </div>
                            </div>

                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.app_share_note') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                    <textarea  placeholder="{{ __('setting.app_share_note') }}" class="form-control {{ $errors->has('app_share_note') ? ' is-invalid' : '' }}" name="app_share_note[{{$trans}}]" rows="5">{{ old('title', $settings['app_share_note']) }}</textarea>
{{--                                         
                                        <input type="text"
                                            class="form-control {{ $errors->has('app_share_note') ? ' is-invalid' : '' }}"
                                            maxlength="500" value="{{ old('title', $settings['app_share_note']) }}"
                                            name="app_share_note[{{$trans}}]" placeholder="{{ __('setting.app_share_note') }}">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> --> --}}
                                        @if ($errors->has('app_share_note'))
                                            <span class="invalid-feedback">{{ $errors->first('app_share_note') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.work_times') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('work_times') ? ' is-invalid' : '' }}"
                                            maxlength="500" value="{{ old('work_times', $settings['work_times']) }}"
                                            name="work_times" placeholder="{{ __('setting.work_times') }}">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('work_times'))
                                            <span class="invalid-feedback">{{ $errors->first('work_times') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.logo') }} Max 500 KB</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <input type="file" name="logo" id="input-file-now-custom-1" class="dropify"
                                            data-default-file="{{ asset( 'storage/app/'. $settings['logo']) }}" />
                                    </div>
                                </div>

 {{--
                            @if ($setting->property == 'agree_conditions1')
                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('agree_conditions1') ? ' is-invalid' : '' }}"
                                            maxlength="500" value="{{ old('agree_conditions1', $setting->value) }}"
                                            name="agree_conditions1" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('agree_conditions1'))
                                            <span class="invalid-feedback">{{ $errors->first('agree_conditions1') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($setting->property == 'agree_conditions2')
                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('agree_conditions2') ? ' is-invalid' : '' }}"
                                            maxlength="500" value="{{ old('agree_conditions2', $setting->value) }}"
                                            name="agree_conditions2" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('agree_conditions2'))
                                            <span class="invalid-feedback">{{ $errors->first('agree_conditions2') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($setting->property == 'agree_conditions3')
                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('agree_conditions3') ? ' is-invalid' : '' }}"
                                            maxlength="500" value="{{ old('agree_conditions3', $setting->value) }}"
                                            name="agree_conditions3" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('agree_conditions3'))
                                            <span class="invalid-feedback">{{ $errors->first('agree_conditions3') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            --}}
                            {{-- @if ($setting->property == 'car_models')
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.car_models') }}
                                        *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="number"
                                            class="form-control {{ $errors->has('car_models_from') ? ' is-invalid' : '' }}"
                                            required maxlength="4" value="{{ old('car_models_from', $setting->value[0]) }}"
                                            name="car_models_from" placeholder="">
                                        @if ($errors->has('car_models_from'))
                                            <span class="invalid-feedback">{{ $errors->first('car_models_from') }}</span>
                                        @endif
                                        <br>
                                        <input type="number"
                                            class="form-control {{ $errors->has('car_models_to') ? ' is-invalid' : '' }}"
                                            required maxlength="4" value="{{ old('car_models_to', $setting->value[1]) }}"
                                            name="car_models_to" placeholder="">
                                        @if ($errors->has('car_models_to'))
                                            <span class="invalid-feedback">{{ $errors->first('car_models_to') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif --}}

                            {{--
                            @if ($setting->property == 'agree_contract')
                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_contract') }}</label>
                                    <div class=" col-lg-7 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('agree_contract') ? ' is-invalid' : '' }}"
                                            maxlength="1000" value="{{ old('agree_contract', $setting->value) }}"
                                            name="agree_contract" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('agree_contract'))
                                            <span class="invalid-feedback">{{ $errors->first('agree_contract') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif

 --}}

                                <div class="form-group row">
                                    <label
                                        class="col-form-label col-lg-3 col-sm-12">{{ __('setting.about_us_image') }} Max 500 KB</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <input type="file" name="about_us_image" id="input-file-now-custom-1"
                                            class="dropify"
                                            data-default-file="{{ asset( 'storage/app/'. $settings['about_us_image']) }}" />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.about_us') }}</label>
                                    <div class=" col-lg-8 col-md-12 col-sm-12">
                                        <textarea name="about_us" class="form-control" data-provide="markdown"
                                            rows="10" placeholder="{{ __('setting.about_us') }}">{{ old('about_us', $settings['about_us']) }}</textarea>
                                        @if ($errors->has('about_us', $settings['about_us']))
                                            <span class="invalid-feedback">{{ $errors->first('about_us') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.terms') }}</label>
                                    <div class=" col-lg-8 col-md-12 col-sm-12">
                                        <textarea name="terms" class="form-control" data-provide="markdown"
                                            rows="10" placeholder="{{ __('setting.terms') }}">{{ old('terms', $settings['terms']) }}</textarea>
                                        @if ($errors->has('terms',$settings['terms']))
                                            <span class="invalid-feedback">{{ $errors->first('terms') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.privacy') }}</label>
                                    <div class=" col-lg-8 col-md-12 col-sm-12">
                                        <textarea name="privacy" class="form-control" data-provide="markdown"
                                            rows="10" placeholder="{{ __('setting.privacy') }}">{{ old('privacy', $settings['privacy']) }}</textarea>
                                        @if ($errors->has('privacy', $settings['privacy']))
                                            <span class="invalid-feedback">{{ $errors->first('privacy') }}</span>
                                        @endif
                                    </div>
                                </div>

 

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.address') }}</label>
                                    <div class="col-lg-8 col-md-9 col-sm-12">
                                        <div id="map" style="width: 100%;height: 500px;"></div>
                                        
                                    </div>
                                </div>


                                @php $lat = $settings['lat'] @endphp
                                <input type="hidden" name="lat" id="lat" value={{ $lat }}>
                                @php $lng = $settings['lng'] @endphp
                                <input type="hidden" name="lng" id="lng" value={{ $lng }}>




                            <x-buttons.but_submit />

                            <!--end::Widget 11-->
                        </div>

                    </div>

                    <!--End::Tab Content-->
                </div>

            </form>


            <div class="col-lg-12 col-md-12">
                <br><br><br>
                <h4 class="card-title">انواع الرسائل</h4>
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if (session('alert_msgtype'))
                    <div class="alert alert-success">{{ session('alert_msgtype') }}</div>
                @endif

                <form class="" action="{{ route('admin.settings.add_msg_type') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-row align-items-center">
                        @csrf
                        <div class="col-auto">
                            <input type="text" id="title" name="title" class="form-control" value="">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">اضافة</button>
                        </div>
                    </div>
                </form>
                <br><br>
                @foreach ($msgTypes as $msgType)

                    <form class="" action="{{ route('admin.settings.update_msg_type', ['id' => $msgType->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        <div class="form-row align-items-center">
                            @csrf
                            <div class="col-auto">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ $msgType->title }}">
                            </div>
                            <div class="col-auto">
                                <!-- <button type="submit" class="btn btn-primary mb-2">{{ trans('word.Save') }}</button> -->
                                <x-buttons.but_submit />
                            </div>
                        </div>
                    </form>
                    <br>
                @endforeach
            </div>


        </div>

        <!--end:: Widgets/Sale Reports-->
    </div>


@section('js_pagelevel')
    <x-admin.dropify-js />

    <x-admin.google-map-js :lat="$lat" :lng="$lng" />
@endsection

@endsection
