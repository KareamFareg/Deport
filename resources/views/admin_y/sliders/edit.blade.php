@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <div class="row">
                <x-buttons.but_back link="{{ route('admin.sliders.index') }}"/>
                 
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.sliders.update', [ 'id' => $data->id ] )}}" method="post">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PUT">

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('slider.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100"
        value="{{ old('title', $data->title) }}" name="title" placeholder="">
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('slider.link') }}</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('link') ? ' is-invalid' : '' }}" required type="text" maxlength="4000"
        value="{{ old('link', $data->link) }}" id="example-number-input" name="link">
        @if ($errors->has('link'))
            <span class="invalid-feedback">{{ $errors->first('link') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" value="{{ $data->imagePath() }}" data-default-file="{{ $data->imagePath() }}" />
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
