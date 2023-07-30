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
                <x-buttons.but_back link="{{ route('admin.categories.index') }}"/>
                  
                <x-admin.trans-bar :languages="$languages" route="{{ route('admin.categories.edit' , ['id' => $data->id ] ) }}" :trans="$trans"/>
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data"
    @if ($data->category_info->isEmpty())
      action="{{route('admin.categories.store_trans',[ 'id'=> $data->id ]) }}" method="post"
    @else
      action="{{route('admin.categories.update' , ['id' => $data->category_info->first()->id ])}}"  method="post"
    @endif>

    @if (!$data->category_info->isEmpty())
    <input name="_method" type="hidden" value="PUT">
    @endif

    {{ csrf_field() }}

    <input type="hidden" value="{{ $trans }}" name="language">

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required
        value="{{ old('title', optional($data->category_info->first())->title) }}" maxlength="100" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>

    {{--
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.type') }}</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('category_type') ? ' is-invalid' : '' }}" id="kt_select2_2" name="category_type">
          @foreach ( $categoryTypes as $key => $categoryType )
            <option {{ old('category_type') == $categoryType ? 'selected' : '' }} value="{{ $categoryType }}">{{ $categoryType }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('category_type'))
                <span class="invalid-feedback">{{ $errors->first('category_type') }}</span>
        @endif
      </div>
    </div>
    --}}


    @if ($data->type == 'category')
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.root') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('parents') ? ' is-invalid' : '' }}" required id="kt_select2_3" name="parents">
          <option {{ old('parents') == 0 ? 'selected' : '' }} value="0">{{ __('category.main_category') }}</option>
          @foreach ( $parents as $parent )
            <option {{ old('parents' , $data->parent_id ) == $parent->id ? 'selected' : '' }} value="{{ $parent->id }}"> {{ $parent->title }} {{str_repeat('__', $parent->depth)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('parents'))
            <span class="invalid-feedback">{{ $errors->first('parents') }}</span>
        @endif
      </div>
    </div>
    @else
    <input type="hidden" value="{{ $data->parent_id }}" name="parents">
    @endif


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.sort') }}</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('sort') ? ' is-invalid' : '' }}" type="number" min="1" maxlength="3"
        value="{{ $data->sort }}" id="example-number-input" name="sort">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('sort'))
            <span class="invalid-feedback">{{ $errors->first('sort') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.description') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" maxlength="1000" placeholder="" rows="8">
          {{ optional($data->category_info->first())->description }}
        </textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ optional($data->category_info->first())->imagePath() }}" />
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
