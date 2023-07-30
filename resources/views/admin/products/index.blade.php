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
                                    action="{{ route('admin.products.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                    placeholder="{{ __('words.title') }}" name="title">
                                            </div>
                                            <div class=" form-group">
                                                <select class="form-control " required
                                                    onchange="getChild(0,$(this).val())" name="parent_id">
                                                    @foreach ( $parents as $category )
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
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
                                                    <select class="form-control "
                                                        onchange="getChild({{$item->id}},$(this).val())" required
                                                        name="">
                                                        @foreach ( $parents as $category )
                                                        <option @if($category->parent_id == $item->category_id) selected
                                                            @endif value="{{ $category->id }}">
                                                            {{ $category->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class=" form-group">
                                                    <select class="form-control child_list_{{$item->id}}" required
                                                        name="category_id">
                                                        @php
                                                        $id = optional(App\Models\Category::find($item->category_id))->parent_id;
                                                        $categoriesIds = App\Models\Category::whereIn('parent_id',
                                                        [$id])->get()->pluck('id');
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



<script>
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