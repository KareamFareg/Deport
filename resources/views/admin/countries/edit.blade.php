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
                                    <x-buttons.but_back link="{{ route('admin.countries.index') }}" />
                                     
                                    <x-admin.trans-bar :languages="$languages"
                                        route="{{ route('admin.countries.edit', ['id' => $data->id]) }}" :trans="$trans" />
                                </div>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">

                            <!-- form -->
                            <form class="kt_form_1" enctype="multipart/form-data"
                                action="{{ route('admin.countries.update', ['id' => $data->id]) }}" method="post">
                                <input name="_method" type="hidden" value="PUT">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $trans }}" name="language">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('country.name') }} *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{$data->translation($trans) }}" name="title[{{ $trans }}]"
                                            placeholder="{{ __('country.name') }}">
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('country.root') }} *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select
                                            class="form-control kt-select2 {{ $errors->has('parent_id') ? ' is-invalid' : '' }}"
                                            id="kt_select2_3" name="parent_id">
                                            <option {{ old('parent_id') == 0 ? 'selected' : '' }} value="1">
                                                {{ __('country.main_area') }}</option>
                                            @foreach ($countries as $country)
                                                <option
                                                    {{ old('parent_id', $data->parent_id) == $country->id ? 'selected' : '' }}
                                                    value="{{ $country->id }}"> {{ $country->translation($trans) }}
                                                    {{ str_repeat('__', $country->depth) }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('parent_id'))
                                            <span class="invalid-feedback">{{ $errors->first('parent_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <x-buttons.but_submit />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@section('js_pagelevel')
    <x-admin.dropify-js />
@endsection

@endsection
