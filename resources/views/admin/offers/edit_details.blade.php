@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

    <!--begin:: Widgets/Sale Reports-->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <div class="row">

                        <x-buttons.but_back link="{{route('admin.offers.edit',['id'=>$offerDetails->offer_id])}}" />
                        <x-admin.trans-bar :languages="$languages"
                            route="{{ route('admin.offers.details.edit',['id'=>$offerDetails->id]) }}"
                            :trans="$trans" />
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">
            <!-- form -->
            <form class="kt_form_1" enctype="multipart/form-data"
                action="{{ route('admin.offers.details.update',['id'=>$offerDetails->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="modal-content">

                    <div class="modal-body">
                        <div class=" form-group">
                            <input class="form-control " required type="text" placeholder="{{ __('words.name') }}"
                                value="{{ $offerDetails->title($trans) }}" name="title[{{$trans}}]">
                        </div>
                        <div class=" form-group">
                            <textarea name="description[{{$trans}}]" class="form-control" id=""
                                placeholder="{{ __('words.description') }}"
                                rows="3">{{$offerDetails->description($trans)}}</textarea>
                        </div>

                        <div class="form-group ">
                            <div id="map" style="height: 500px;"></div>
                        </div>


                        @php $lat = $offerDetails['lat'] @endphp
                        <input type="hidden" name="lat" id="lat" value="{{ $lat }}">
                        @php $lng = $offerDetails['lng'] @endphp
                        <input type="hidden" name="lng" id="lng" value="{{ $lng }}">

                        <div class=" form-group row">
                            <div class="col-md-10">
                                <label for="">{{__('words.logo')}}</label>
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <img style="width: 50%" class="img-responsive img-thumbnail img-rounded"
                                    src="{{ $offerDetails->logo ? asset('storage/app/' . $offerDetails->logo) : $emptyImage }}">

                            </div>
                        </div>

                        <div class="form-group row">

                            @foreach($offerDetails->images as $key=>$image)
                            <div class="col-md-2 ">

                                <div>
                                    <span title="Delete Image" class="tooltips" data-toggle="modal"
                                        data-target="#image_details-{{$key}}" style="  cursor: pointer">

                                        <img src="{{ $image ? asset('storage/app/' . $image) : $emptyImage }}"
                                            style="max-height : 100px"
                                            class="  img-responsive img-thumbnail img-rounded">
                                    </span>


                                </div>

                                <div class="modal  fade" id="image_details-{{$key}}" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog   modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5> {{__('messages.confirm_delete')}} </h5>
                                            </div>
                                            <div class="modal-content">
                                                <div class="modal-body" style=" text-align: center;  ">
                                                    <img style="width : 50% "
                                                        src="{{ $image ? asset('storage/app/' . $image) : $emptyImage }}"
                                                        class="  img-responsive ">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-outline-success"
                                                    type="button">{{__('messages.no')}}
                                                </button>
                                                <a href="{{ route('admin.offers.details.delete_image',['id'=>$offerDetails->id,'index'=>$key]) }}"
                                                    class="btn btn-outline-danger"> {{__('messages.yes_delete')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <div class=" form-group">
                            <label>{{__('words.images')}}</label>
                            <div class="form-group incrementImage control-group input-group">
                                <input type="file" name="images[]" class="form-control">
                                <label for="ex5">&nbsp;</label>
                                <div class="input-group-btn">
                                    <button class="btn btn-success addImage" type="button">{{__('words.add')}}
                                    </button>
                                </div>

                                <div class="cloneImage " style="display: none">
                                    <div class="control-group input-group"
                                        style="margin-top:10px ; margin-bottom: 10px">
                                        <input type="file" name="images[]" class="form-control">
                                        <label for="ex5">&nbsp;</label>
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger removeImage" type="button">
                                                {{__('words.delete')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">
                            <x-buttons.but_update />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('js_pagelevel')
<x-admin.dropify-js />
<x-admin.google-map-js :lat="$lat" :lng="$lng" />

<script !src="">
    $(document).ready(function () {

        $(".addImage").click(function () {
            var html =  $(this).parents(".incrementImage").children(".cloneImage").html();
            $(this).parents(".incrementImage").after(html);
        });

        $("body").on("click", ".removeImage", function () {
            $(this).parents(".control-group").remove();
        });

   

    });
</script>
@endsection