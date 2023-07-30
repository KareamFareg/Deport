@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

    <!--begin:: Widgets/Sale Reports-->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <div class="row">
                        <a style="margin: 10px">{{ __('offers.images') }}</a>
                        <x-buttons.but_back link="{{route('admin.offers.index')}}" />
                        <x-admin.trans-bar :languages="$languages"
                            route="{{ route('admin.offers.edit',['id'=>$offer->id]) }}" :trans="$trans" />
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">
            <!-- form -->
            <form class="kt_form_1" enctype="multipart/form-data"
                action="{{ route('admin.offers.update',['id'=>$offer->id]) }}" method="post">
                {{ csrf_field() }}
                <div class="modal-content">

                    <div class="modal-body">
                        <div class=" form-group">
                            <input class="form-control" type="text" value=" {{ $offer->title($trans)}}" required
                                placeholder="{{ __('words.title') }}" name="title[{{$trans}}]">
                        </div>

                        <div class=" form-group row">
                            <div class="col-md-10">
                                <label for="">{{__('words.logo')}}</label>
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <img style="width: 50%" class="img-responsive img-thumbnail img-rounded"
                                    src="{{ $offer->logo ? asset('storage/app/' . $offer->logo) : $emptyImage }}">

                            </div>
                        </div>


                        <div class="form-group row">

                            @foreach($offer->images as $key=>$image)
                            <div class="col-md-2 ">

                                <div>
                                    <span title="Delete Image" class="tooltips" data-toggle="modal"
                                        data-target="#image{{$key}}" style="  cursor: pointer">

                                        <img src="{{ $image ? asset('storage/app/' . $image) : $emptyImage }}"
                                            style="max-height : 100px"
                                            class="  img-responsive img-thumbnail img-rounded">
                                    </span>


                                </div>

                                

                                <div class="modal  fade" id="image{{$key}}" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered ">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5> {{__('messages.confirm_delete')}} </h5>
                                            </div>
                                            <div class="modal-content">
                                                <div class="modal-body" style=" text-align: center;">
                                                    <img style="width : 50% "
                                                        src="{{ $image ? asset('storage/app/' . $image) : $emptyImage }}"
                                                        class="  img-responsive ">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-outline-success"
                                                    type="button">{{__('messages.no')}}
                                                </button>
                                                <a href="{{ route('admin.offers.delete_image',['id'=>$offer->id,'index'=>$key]) }}"
                                                    class="btn btn-outline-danger"> {{__('messages.yes_delete')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class=" form-group">

                            <div class="form-group incrementImage control-group input-group">
                                <input type="file" name="images[]" class="form-control">
                                <label for="ex5">&nbsp;</label>
                                <div class="input-group-btn">
                                    <button class="btn btn-success addImage" type="button">
                                        {{__('words.add')}}
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
                                    action="{{ route('admin.products.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$offer->id}}" name="offer_id">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                    placeholder="{{ __('words.title') }}" name="title">
                                            </div>
                                        
                                            <div class=" form-group">
                                                <select class="form-control child_list_0" required name="category_id">
                                                    @foreach ( $categories as $category )
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class=" form-group">
                                                <label for="">Max 300MB *</label>
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

                        {{-- <x-admin.trans-bar :languages="$languages" route="{{ route('admin.how_to_use.index') }}"
                        :trans="$trans" /> --}}
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">

            <table class="table table-striped- table-bordered table-hover table-checkable">

                <thead>
                    <tr>
                        <td style="width:20%">{{ __('words.title') }}</td>
                        <td style="width:50%">{{ __('words.category') }}</td>
                        <td style="width:15%">{{ __('words.image') }}</td>
                        <td style="width:15%">{{ __('words.control') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>
                            {{ $item->title}}
                        </td>
                        <td>
                            @php
                            $category = App\Services\CategoryService::queryParents([$item->category_id]);
                            @endphp
                            {{ optional($category)[0]->title  ?? ''}}
                        </td>
                        <td>
                            {{-- <img src="{{ $item->image ? asset('storage/app/' . $item->image) : $emptyImage }}">
                            --}}
                            <img style="width: 100px" class="img-responsive img-thumbnail img-rounded"
                                src="{{ $item->image ? asset('storage/app/' . $item->image) : $emptyImage }}">


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
                                        action="{{ route('admin.products.update', ['id' => $item->id]) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$item->title}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class=" form-group">
                                                    <input class="form-control " required type="text"
                                                        value="{{ $item->title }}" name="title">
                                                </div>

                                               
                                                <div class=" form-group">
                                                    <select class="form-control " required
                                                        name="category_id">
                                                        @php
                                                        $categoriesIds = App\Models\Category::whereIn('parent_id',
                                                        [1])->get()->pluck('id');
                                                        $childs =
                                                        App\Services\CategoryService::queryParents($categoriesIds);
                                                        @endphp

                                                        @if($childs)
                                                        @foreach ( $childs
                                                        as $category )
                                                        <option @if($category->id == $item->category_id) selected @endif
                                                            value="{{ $category->id }}">
                                                            {{ $category->title }}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>


                                                <div class=" form-group">
                                                    <label for="">Max 300MB *</label>
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

                            <x-buttons.but_delete_one link="{{route('admin.products.delete',['id'=>$item->id])}}" />

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
<x-admin.google-map-js :lat="0" :lng="0" />

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

    function getChild(id,val) {
      if(val) {
          $.ajax({
              type: "get",
              url: "{{route('admin.products.getChild')}}",
              data:{"id": val},
              success: function(data){
                console.log(data);
                  $(".child_list_"+id).html(data);
               }
          }); 
      }
  }
</script>
@endsection
