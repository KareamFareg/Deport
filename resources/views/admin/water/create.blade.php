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

                        <h2>اضافه منتجات سقيا الماء</h2>
                            <!-- form -->
                            <form class="kt_form_1" enctype="multipart/form-data"
                                action="{{ route('admin.souqProducts.store') }}" method="post">
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">اسم المنتج *</label>
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
                                    <label class="col-form-label col-lg-3 col-sm-12">وصف المنتج *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('describe') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{ old('describe') }}" name="describe" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('describe'))
                                            <span class="invalid-feedback">{{ $errors->first('describe') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">سعر المنتج *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                        <input type="text"
                                            class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" required
                                            maxlength="100" value="{{ old('price') }}" name="price" placeholder="">
                                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div>
                              
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">صوره المتجر  Max 500 KB</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input type="file" name="image" class="dropify" data-default-file="" required />
                                    </div>
                                </div>
                                <input type="number" value="48"  name="category" hidden/>
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
