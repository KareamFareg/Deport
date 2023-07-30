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
                                    action="{{ route('admin.offers.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                    placeholder="{{ __('words.title') }}" name="title[{{$trans}}]">
                                            </div>
                                          
                                            <div class=" form-group">
                                                <label for="">{{__('words.logo')}}</label>
                                                <input type="file" name="logo" required="" class="form-control">
                                            </div>


                                            <div class=" form-group">
                                                {{-- <input type="file" name="images[]"  class="dropify"
                                                    multiple data-default-file="" /> --}}
                                                    <div class="form-group incrementImage control-group input-group">
                                                        <input type="file" name="images[]" required="" class="form-control dropify">
                                                        <label for="ex5">&nbsp;</label>
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-success addImage" type="button"><i
                                                                    class="glyphicon glyphicon-plus"></i>{{__('words.add')}}
                                                            </button>
                                                        </div>
                            
                                                        <div class="cloneImage " style="display: none">
                                                            <div class="control-group input-group"
                                                                 style="margin-top:10px ; margin-bottom: 10px">
                                                                <input type="file" name="images[]"  class="form-control dropify">
                                                                <label for="ex5">&nbsp;</label>
                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-danger removeImage" type="button"><i
                                                                            class="glyphicon glyphicon-remove"></i> {{__('words.delete')}}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                    </div>

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

                        <x-admin.trans-bar :languages="$languages" route="{{ route('admin.offers.index') }}"
                            :trans="$trans" />
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">

            <table class="table table-striped- table-bordered table-hover table-checkable">

                <thead>
                    <tr>
                        <td style="width:20%">{{ __('words.title') }}</td>
                        <td style="width:15%">{{ __('words.logo') }}</td>
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
                            
                            <a class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5"
                                data-toggle="kt-tooltip" data-placement="right">
                                <img src="{{ $item->logo ? asset('storage/app/' . $item->logo) : $emptyImage }}">
                            </a>
                        </td><td>
                            
                            <a class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5"
                                data-toggle="kt-tooltip" data-placement="right">
                                <img src="{{ $item->images ? asset('storage/app/' . $item->images[0]) : $emptyImage }}">
                            </a>
                        </td>
                        <td>

                           

                            <x-buttons.but_edit link="{{route('admin.offers.edit',['id'=>$item->id])}}" />
                            <x-buttons.but_delete_one link="{{route('admin.offers.delete',['id'=>$item->id])}}" />

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

<script !src="">
    $(document).ready(function () {

        $(".addImage").click(function () {
            var html = $(".cloneImage").html();
            $(".incrementImage").after(html);
        });

        $("body").on("click", ".removeImage", function () {
            $(this).parents(".control-group").remove();
        });

   

    });
</script>
@endsection