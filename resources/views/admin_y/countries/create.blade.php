@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.countries.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.countries.store')}}" method="post">
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
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('country.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100"
        value="{{ old('title') }}" name="title" placeholder="">
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('country.root') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('parent_id') ? ' is-invalid' : '' }}" id="kt_select2_3" name="parent_id">
          <option {{ old('parent_id') == 0 ? 'selected' : '' }} value="0">{{ __('country.main_country') }}</option>
          @foreach ( $countries as $country )
            <option {{ old('parent_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}"> {{ $country->title }} {{str_repeat('__', $country->depth)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('parent_id'))
            <span class="invalid-feedback">{{ $errors->first('parent_id') }}</span>
        @endif
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
@endsection

@endsection
