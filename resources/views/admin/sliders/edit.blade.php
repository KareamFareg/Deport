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
                                <x-buttons.but_back link="{{ route('admin.sliders.index') }}" />
                            </div>
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">

                        <div class="form-group ">
                            <h5>{{ $data->position }}</h5>
                            <p>{{ $data->note }}</p>
                        </div>
                        <!-- form -->
                        <form class="kt_form_1" enctype="multipart/form-data"
                            action="{{ route('admin.sliders.update', ['id' => $data->id]) }}" method="post">
                            {{ csrf_field() }}

                            <input name="_method" type="hidden" value="PUT">
                            <div class="form-group">
                                <div class=" row">
                                    {{-- <div class=" col-lg-4 col-md-9 col-sm-12">
                                                 <label class="col-form-label ">{{ __('slider.title') }}</label>
                                    <input type="text"
                                        class="form-control {{ $errors->has('title') ? '  ' : '' }}" required
                                        maxlength="100" name="title" placeholder="">
                                </div> --}}
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <label class="col-form-label ">{{ __('slider.link') }}</label>
                                    <input class="form-control {{ $errors->has('link') ? '' : '' }}" 
                                        type="text" maxlength="4000"  placeholder="{{ __('slider.link') }}" id="example-number-input" name="link">
                                </div>
                                <div class=" col-lg-4 col-md-9 col-sm-12">
                                    <label class="col-form-label ">{{ __('words.image') }}</label>
                                    <input required type="file" name="image" id="input-file-now-custom-1" class="form-control" />
                                </div>
                                <div class="col-lg-2">
                                    <label class="col-form-label ">&nbsp;</label>
                                    <button class="form-control btn btn-success " type="submit">
                                        <i class="fa fa-plus"></i>اضافة
                                    </button>
                                </div>
                            </div>
                    </div>
                    </form>

                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable">
                            <thead>
                                <tr>
                                    {{-- <th>{{ __('slider.title') }}</th>--}}
                                    <th>{{ __('slider.link') }}</th>
                                    <th>{{ __('words.image') }}</th>
                                    <th>{{ __('slider.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->images as $key => $item)
                                <tr>
                                    {{-- <td>{{ $item['title'] }}</td>--}}
                                    <td>{{ $item['link'] }}</td>
                                    <td>
                                        <img src="{{ asset('storage/app/' . $item['image']) }}"
                                            style="max-height : 100px"
                                            class="  img-responsive img-thumbnail img-rounded">

                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                            data-target="#EditModal-{{ $key }}">{{trans('words.edit')}}</button>
                                        |
                                        <x-buttons.but_delete_one
                                            link="{{  route('admin.sliders.delete', ['id' => $data->id, 'imageIndex' => $key])  }}" />


                                        <!--begin:: Edit Modal-->
                                        <div class="modal fade" id="EditModal-{{ $key }}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <!-- form -->
                                                <form class="kt_form_1" enctype="multipart/form-data"
                                                    action="{{ route('admin.sliders.update', ['id' => $data->id]) }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                تعديل السلايدر</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">


                                                            <input name="_method" type="hidden" value="PUT">
                                                            <input name="imageIndex" type="hidden" value="{{ $key }}">

                                                            <div class=" form-group">
                                                                {{-- <label
                                                                    class="col-form-label ">{{ __('slider.title') }}</label>
                                                                <input type="text"
                                                                    class="form-control {{ $errors->has('title') ? '  ' : '' }}"
                                                                    required maxlength="100"
                                                                    value="{{ $item['title'] }}" name="title"
                                                                    placeholder="">
                                                            </div>--}}
                                                            <div class=" form-group">
                                                                <label
                                                                    class="col-form-label ">{{ __('slider.link') }}</label>
                                                                <input
                                                                    class="form-control {{ $errors->has('link') ? '  ' : '' }}"
                                                                     type="text" maxlength="4000"
                                                                    value="{{ $item['link'] }}" placeholder="{{ __('slider.link') }}"
                                                                    id="example-number-input" name="link">


                                                            </div>
                                                            <div class=" form-group">
                                                                <label
                                                                    class="col-form-label ">{{ __('words.image') }}</label>
                                                                <input type="file" name="image"
                                                                    id="input-file-now-custom-1" class="dropify"
                                                                    value="{{ asset('storage/app/' . $item['image']) }}"
                                                                    data-default-file="{{ asset('storage/app/' . $item['image']) }}" />

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">اغلاق</button>
                                                            <button class=" btn btn-success " type="submit">
                                                                <i class="fa fa-plus"></i>تعديل
                                                            </button>
                                                        </div>
                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                        <!--end::Modal-->


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!--end: Datatable -->
                    </div>

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