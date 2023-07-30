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
                                action="{{ route('admin.mktn.store') }}" method="post">
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">اسم السوق *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{ old('name') }}" name="name" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12"> اسم المدينه *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{ old('city') }}" name="city" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('city'))
                                            <span class="invalid-feedback">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">صوره السوق  Max 500 KB</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input type="file" name="icon" data-default-file="" class="form-control dropify"/>
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
