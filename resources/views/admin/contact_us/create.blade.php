@extends('admin.layouts.master')

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{ __('contact_us.contact_us') }} : &nbsp;&nbsp;
                                {{ $settings['phone_1'] }} &nbsp;&nbsp;-&nbsp;&nbsp;
                                {{ $settings['mail'] }}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">


                            <!-- form -->
                            <form class="kt_form_1" enctype="multipart/form-data"
                                action="{{ route('admin.contacts.store') }}" method="post">
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('contact_us.name') }} *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{ old('title') }}" name="title" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.mobile') }} *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" required
                                            maxlength="10" value="{{ old('mobile') }}" name="mobile" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('mobile'))
                                            <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('contact_us.type') }} *</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                        <select
                                            class="form-control kt-select2 {{ $errors->has('contact_us_type_id') ? ' is-invalid' : '' }}"
                                            id="kt_select2_1" name="contact_us_type_id">
                                            @foreach ($contactUsTypes as $contactUsType)
                                                <option
                                                    {{ old('contact_us_type_id') == $contactUsType->id ? 'selected' : '' }}
                                                    value="{{ $contactUsType->id }}"> {{ $contactUsType->title }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('contact_us_type_id'))
                                            <span class="invalid-feedback">{{ $errors->first('contact_us_type_id') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.description') }} *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <textarea
                                            class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                            max="4000" required name="description" placeholder=""
                                            rows="6">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
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
