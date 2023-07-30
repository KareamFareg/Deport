@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.roles.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.roles.store')}}" method="post">
    {{ csrf_field() }}


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100" value="{{ old('title') }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12"> *</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="kt-checkbox-list">
          <label class="kt-checkbox">
            <input type="checkbox" name="role_for" value="1">{{ __('role.role_for') }}
            <span></span>
          </label>
        </div>
        <!-- <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span> -->
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="kt-checkbox-list">
          @foreach ($privilegesAll as $privilege)
          <label class="kt-checkbox">
            <input type="checkbox" value="{{ $privilege->id }}" name="privileges[]">{{ $privilege->title }}
            <span></span>
          </label>
          @endforeach
        </div>
        <!-- <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span> -->
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

@endsection

@endsection
