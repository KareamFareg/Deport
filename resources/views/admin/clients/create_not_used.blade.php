@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.clients.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.clients.store')}}" method="post">
    {{ csrf_field() }}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('language.title') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('language') ? ' is-invalid' : '' }}" required id="kt_select2_1" name="language">
          @foreach ( $languages as $language )
            <option {{ old('language') == $language->locale ? 'selected' : '' }} value="{{ $language->locale }}">{{ $language->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('language'))
            <span class="invalid-feedback">{{ $errors->first('language') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('country.title') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('country_id') ? ' is-invalid' : '' }}" required id="kt_select2_2" name="country_id">
          @foreach ( $countries as $country )
            <option {{ old('country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}  {{str_repeat('__', $country->depth)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('country_id'))
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        @endif
      </div>
    </div>


    {{--
    @if ( request()->user()->isAdmin() )
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.clients') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="kt_select2_3" required name="user_id">
          @foreach ( $users as $user )
            <option {{ old('user_id') == $user->id ? 'selected' : '' }} value="{{ $user->id }}"> {{ $user->name }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('user_id'))
            <span class="invalid-feedback">{{ $errors->first('user_id') }}</span>
        @endif
      </div>
    </div>
    @endif
    --}}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('client.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" maxlength="100" required value="{{ old('title') }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.contacts') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('contacts') ? ' is-invalid' : '' }}" max="4000" name="contacts" placeholder="" rows="8"></textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('contacts'))
            <span class="invalid-feedback">{{ $errors->first('contacts') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.phone') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" max="200" name="phone" placeholder="" rows="8"></textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('phone'))
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.address') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" max="1000" name="address" placeholder="" rows="8"></textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('address'))
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('client.commerce_no') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('commerce_no') ? ' is-invalid' : '' }}" max="500" required name="commerce_no" placeholder="" rows="8"></textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('commerce_no'))
            <span class="invalid-feedback">{{ $errors->first('commerce_no') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.logo') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="logo" id="input-file-now-custom-1" class="dropify" data-default-file="" />
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.banner') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="banner" id="input-file-now-custom-1" class="dropify" data-default-file="" />
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.description') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" max="4000" name="description" placeholder="" rows="8"></textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
        @endif
      </div>
    </div>



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div id="map" style="width: 700px;height: 500px;"></div>
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">
      </div>
    </div>


    <x-buttons.but_submit/>

</form>





          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@section('js_pagelevel')
<x-admin.dropify-js/>
<x-admin.google-map-js/>
@endsection

@endsection
