@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.items.index') }}"/>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.items.store')}}" method="post">
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


    @if ( request()->user()->isAdmin() )
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.clients') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="kt_select2_3" required name="user_id">
          @foreach ( $users as $user )
            <option {{ old('user_id') == $user->id ? 'selected' : '' }} value="{{ $user->id }}"> {{ optional($user->client->client_info->first())->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('user_id'))
            <span class="invalid-feedback">{{ $errors->first('user_id') }}</span>
        @endif
      </div>
    </div>
    @endif


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('item.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" maxlength="100" required value="{{ old('title') }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
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


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.root') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_4" required name="category_id">
          @foreach ( $categories as $category )
            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth ?? 0)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('category_id'))
            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
        @endif
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
        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="" />
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
