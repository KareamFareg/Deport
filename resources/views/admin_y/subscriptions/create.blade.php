@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.subscriptions.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.subscriptions.store')}}" method="post">
    {{ csrf_field() }}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('subscription.code') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="number" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}"  required  maxlength="7" value="{{ old('code') }}" name="code" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('code'))
                <span class="invalid-feedback">{{ $errors->first('code') }}</span>
        @endif
      </div>
    </div>



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('subscription_package.name') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('subscription_packages_id') ? ' is-invalid' : '' }}" required id="kt_select2_2" name="subscription_packages_id">
          @foreach ( $subscriptionPackages as $subscriptionPackage )
            <option {{ old('subscription_packages_id') == $subscriptionPackage->id ? 'selected' : '' }} value="{{ $subscriptionPackage->id }}"> {{ $subscriptionPackage->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('subscription_packages_id'))
            <span class="invalid-feedback">{{ $errors->first('subscription_packages_id') }}</span>
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
