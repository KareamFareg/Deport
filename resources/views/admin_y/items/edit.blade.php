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
                <x-buttons.but_back link="{{ route('admin.items.index') }}"/>
                 
                <x-admin.trans-bar :languages="$languages" route="{{ route('admin.items.edit' , ['id' => $data->id ] ) }}" :trans="$trans"/>
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data"
    @if ($data->item_info->isEmpty())
      action="{{route('admin.items.store_trans',[ 'id'=> $data->id ]) }}" method="post"
    @else
      action="{{route('admin.items.update' , ['id' => $data->item_info->first()->id ])}}"  method="post"
    @endif>

    @if (!$data->item_info->isEmpty())
    <input name="_method" type="hidden" value="PUT">
    @endif

    {{ csrf_field() }}

    <input type="hidden" value="{{ $trans }}" name="language">


    @if ( request()->user()->isAdmin() )
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.clients') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="kt_select2_4" required name="user_id">
          @foreach ( $users as $user )
            <option {{ old('user_id',$data->user_id) == $user->id ? 'selected' : '' }} value="{{ $user->id }}"> {{ optional($user->client->client_info->first())->title }}</option>
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
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" maxlength="100" required
        value="{{ old('title' , optional($data->item_info->first())->title ) }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.price') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" type="number" step=".01" required
        value="{{ old('price' , $data->price ) }}" id="example-number-input" name="price">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('price'))
            <span class="invalid-feedback">{{ $errors->first('price') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('category.root') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_3" required name="category_id">
          @foreach ( $categories as $category )
            <option {{ old('category_id', $data->category->first()->id) == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth ?? 0)}}</option>
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
        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" max="4000" name="description" placeholder="" rows="8">{{ optional($data->item_info->first())->description }}</textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ optional($data->item_info->first())->imagePath() }}" />
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
