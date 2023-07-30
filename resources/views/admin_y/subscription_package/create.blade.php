@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.subscriptionpackages.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.subscriptionpackages.store')}}" method="post">
    {{ csrf_field() }}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('subscription_package.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100" value="{{ old('title') }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.root') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" required id="kt_select2_2" name="category_id">
          @foreach ( $categories as $category )
            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('category_id'))
            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('subscription_package.for_clients') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('user_type_id') ? ' is-invalid' : '' }}" required id="kt_select2_3" name="user_type_id">
          @foreach ( $userTypes as $userType )
            <option {{ old('user_type_id') == $userType->id ? 'selected' : '' }} value="{{ $userType->id }}"> {{ $userType->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('user_type_id'))
            <span class="invalid-feedback">{{ $errors->first('user_type_id') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('subscription_package.period') }}</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('period') ? ' is-invalid' : '' }}" type="number" min="1" maxlength="3" id="example-number-input" name="period">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('period'))
            <span class="invalid-feedback">{{ $errors->first('period') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.price') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" type="number" step=".01" required id="example-number-input" name="price">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('price'))
            <span class="invalid-feedback">{{ $errors->first('price') }}</span>
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
