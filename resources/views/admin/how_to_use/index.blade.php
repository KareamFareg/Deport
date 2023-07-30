@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

    <!--begin:: Widgets/Sale Reports-->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">



        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <div class="row">
                        <button style="margin: 10px" type="button" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#Add">{{trans('words.add')}}</button>
                        <!--begin:: Edit Modal-->
                        <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- form -->
                                <form class="kt_form_1" enctype="multipart/form-data"
                                    action="{{ route('admin.how_to_use.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                    placeholder="{{ __('words.title') }}" name="title[{{$trans}}]">
                                            </div>
                                            <div class=" form-group">
                                                <textarea name="description[{{$trans}}]" class="form-control" id=""
                                                    placeholder="{{ __('words.description') }}" rows="3"></textarea>
                                            </div>
                                            <div class=" form-group">
                                                <select name="type" class="form-control" id="">
                                                    <option value="1">{{ __('user.clients') }}</option>
                                                    <option value="2">{{ __('user.shippers') }}</option>
                                                </select>
                                            </div>

                                            <div class=" form-group">
                                                <label for="">Max 300 KB *</label>
                                                <input type="file" name="image" id="input-file-now-custom-1"
                                                    class="dropify" data-default-file="" />


                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.add')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Modal-->

                        <x-admin.trans-bar :languages="$languages" route="{{ route('admin.how_to_use.index') }}"
                            :trans="$trans" />
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">

            <table class="table-responsive table table-striped- table-bordered table-hover table-checkable">

                <thead>
                    <tr>
                        <td style="width:20%">{{ __('words.title') }}</td>
                        <td style="width:50%">{{ __('words.description') }}</td>
                        <td style="width:15%">{{ __('words.type') }}</td>
                        <td style="width:15%">{{ __('words.image') }}</td>
                        <td style="width:15%">{{ __('words.control') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>
                            {{ $item->title($trans)}}
                        </td>
                        <td>
                            {{$item->description($trans)}}
                        </td> 
                        <td>
                            @if($item->type == 1) {{ __('user.clients') }} @else {{ __('user.shippers') }} @endif
                        </td>
                        <td>
                            {{-- <img src="{{ $item->image ? asset('storage/app/' . $item->image) : $emptyImage }}">
                            --}}
                            <a class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5"
                                data-toggle="kt-tooltip" data-placement="right">
                                <img src="{{ $item->image ? asset('storage/app/' . $item->image) : $emptyImage }}">
                            </a>
                        </td>
                        <td>

                            <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#EditModal-{{ $item->id }}">{{trans('words.edit')}}</button>
                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="EditModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!-- form -->
                                    <form class="kt_form_1" enctype="multipart/form-data"
                                        action="{{ route('admin.how_to_use.update', ['id' => $item->id]) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$item->title($trans)}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class=" form-group">
                                                    <input class="form-control " required type="text"
                                                        value="{{ $item->title($trans) }}" name="title[{{$trans}}]">
                                                </div>
                                                <div class=" form-group">
                                                    <textarea name="description[{{$trans}}]" class="form-control" id=""
                                                        placeholder="{{ __('words.description') }}"
                                                        rows="3">{{$item->description($trans)}}</textarea>
                                                </div>
                                                <select name="type" class="form-control" id="">
                                                    <option @if($item->type == 1) selected @endif  value="1">{{ __('user.clients') }}</option>
                                                    <option @if($item->type == 2) selected @endif  value="2">{{ __('user.shippers') }}</option>
                                                </select>


                                                <div class=" form-group">
                                                    <label for="">Max 300 KB *</label>
                                                    <input type="file" name="image" id="input-file-now-custom-1"
                                                        class="dropify"
                                                        data-default-file="{{ $item->image ? asset('storage/app/' . $item->image) : $emptyImage }}" />
                                                </div>


                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-pincel"></i>{{__('words.edit')}}
                                                </button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <!--end::Modal-->

                            <x-buttons.but_delete_one link="{{route('admin.how_to_use.delete',['id'=>$item->id])}}" />

                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>




    </div>

    <!--end:: Widgets/Sale Reports-->
</div>




@endsection

@section('js_pagelevel')
<x-admin.dropify-js />


@endsection