@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <div class="row">
              <x-buttons.but_back link="{{ route('admin.packagetypes.index') }}"/>
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.packagetypes.edit' , ['id' => $data->id ] ) }}" :trans="$trans"/>
            </div>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data"
    @if ($data->package_type_info->isEmpty())
      action="{{route('admin.packagetypes.store_trans',[ 'id'=> $data->id ]) }}" method="post"
    @else
      action="{{route('admin.packagetypes.update' , ['id' => $data->package_type_info->first()->id ])}}"  method="post"
    @endif>

    @if (!$data->package_type_info->isEmpty())
    <input name="_method" type="hidden" value="PUT">
    @endif

    {{ csrf_field() }}

    <input type="hidden" value="{{ $trans }}" name="language">


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('package_type.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">

        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required
        value="{{ old('title' , optional($data->package_type_info->first())->title ) }}" maxlength="40" name="title" placeholder="">
        @if ($errors->has('title'))
              <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.price') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" type="number"
        value="{{ old('price' , $data->price) }}" step=".01" required id="example-number-input" name="price">
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
