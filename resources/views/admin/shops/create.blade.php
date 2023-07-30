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
                                action="{{ route('admin.shops.store') }}" method="post">
                                {{ csrf_field() }}


                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">اسم المتجر *</label>
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
                                    <label class="col-form-label col-lg-3 col-sm-12">نوع المتجر *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                      
                                        @foreach($categories as $category)   
                                        <input type="checkbox" name="category[]" value="<?=$category->id?>"  style="margin:10px"> <label>{{$category->title}}<label>
                    
                                            @endforeach
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback">{{ $errors->first('category') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">اسم السوق التابع له هذا المتجر *</label>
                                    <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <select name='souq_id'  class="form-control">
                                            @foreach($souqs as $souq)
                                               <option value="<?=$souq->id?>">{{$souq->name}}</option>    
                                             @endforeach
                                        <select>
                                        @if ($errors->has('souq_id'))
                                            <span class="invalid-feedback">{{ $errors->first('souq_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">صوره المتجر  Max 500 KB</label>
                                    <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input type="file" name="icon" class="dropify" data-default-file="" />
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
