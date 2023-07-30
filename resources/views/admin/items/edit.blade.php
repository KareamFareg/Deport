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
                @if ($item->type_id == 1)
                <x-buttons.but_back link="{{ route('admin.items.index_offers') }}"/>
                @endif
                @if ($item->type_id == 2)
                <x-buttons.but_back link="{{ route('admin.items.index_coupons') }}"/>
                @endif
                 
                {{--<x-admin.trans-bar :languages="$languages" route="{{ route('admin.items.edit' , ['id' => $data->id ] ) }}" :trans="$trans"/>--}}
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('item.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" maxlength="100" required
        value="{{ old('title' , optional($item->item_info->first())->title ) }}" name="title" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.links') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('links') ? ' is-invalid' : '' }}" maxlength="100" required
        value="{{ old('links' , $item->links) }}" name="links" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('links'))
                <span class="invalid-feedback">{{ $errors->first('links') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.description') }}</label>
      <div class=" col-lg-6 col-md-9 col-sm-12">
        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" max="4000" name="description" placeholder="" rows="8">{{ optional($item->item_info->first())->description }}</textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
        @endif
      </div>
    </div>

    @foreach ($item->files as $file)
        <div class="form-group row">
          <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
          <div class="col-lg-9 col-md-9 col-sm-12">
            <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ $file->filePath() }}" />
            <x-buttons.but_delete link="{{ route('admin.items.destroy_file',[ 'id'=> $item->id  , 'file_id' => $file->id ]) }}"/>
          </div>
        </div>
    @endforeach


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
