@extends('admin.layouts.master')





@section('content')




<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

        <div class="kt-portlet__body">
            <form class="kt_form_1 row" enctype="multipart/form-data" action="{{ route('admin.coupons.index') }}"
                method="post">
                {{ csrf_field() }}
                
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.from')}}</label>
                    <input class="form-control datepicker" type="text" autocomplete="off" value="{{$from ?? ''}}" name="from">
                </div>
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.to')}}</label>
                    <input class="form-control datepicker" autocomplete="off" type="text" value="{{$to ?? ''}}" name="to">
                </div>
                <div class="form-group col-lg-1">
                    <label for="">&nbsp;</label>
                    <button class="form-control btn btn-success " type="submit">
                        <i class=" flaticon flaticon2-search-1"></i>{{__('words.search')}}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
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
                                    action="{{ route('admin.coupons.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <label for="">{{ __('coupon.title') }}</label>
                                                <input class="form-control" type="text" required
                                                placeholder="{{ __('coupon.title') }}" name="title">
                                            </div>
                                             <div class=" form-group">
                                                 
                                                 <label> {{ __('coupon.auto_generate_text') }}</label>
                                                <input class="form-control" type="text" 
                                                placeholder="{{ __('coupon.coupon') }}" name="coupon">
                                            </div>
                                            <div class=" form-group">
                                                <label for="">{{ __('coupon.amount') }}</label>
                                               <input class="form-control" type="number" min="0"  required
                                               placeholder="{{ __('coupon.amount') }}" name="amount">
                                           </div>
                                           <div class=" form-group">
                                               <label for="">{{ __('coupon.limit') }}</label>
                                               <input class="form-control" type="number" min="0"  required
                                               placeholder="{{ __('coupon.limit') }}" name="limit">
                                           </div>
                                            <div class=" form-group">
                                                <label for="">{{ __('coupon.expire_date') }}</label>
                                                <input class="form-control datepicker" type="text" autocomplete="off" required   placeholder="yyyy-mm-dd" 
                                                placeholder="{{ __('coupon.expire_date') }}" name="expire_date">
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

                      
                    </div>
                </h3>
            </div>

        </div>

        <div class="kt-portlet__body">
            <style>
                .dataTables_wrapper div.dataTables_filter {
                    display: contents;
                }
            </style>

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('coupon.title') }}</th>
                        <th>{{ __('coupon.coupon') }}</th>
                        <th>{{ __('coupon.amount') }}</th>
                        <th>{{ __('coupon.limit') }}</th>
                        <th>{{ __('coupon.used') }}</th>
                        <th>{{ __('coupon.expire_date') }}</th>
                        <th>{{ __('coupon.create_date') }}</th>
                        <th>{{ __('words.control') }}</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->coupon }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->limit }}</td>
                        <td><a class="btn btn-outline-warning" href="{{route('admin.coupons.users',['coupon'=>$item->coupon])}}"><i class="fa fa-eye "></i> {{ \App\Models\Order::where('coupon',$item->coupon)->count() }}</a></td>
                        <td>{{ $item->expire_date }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#EditModal-{{ $item->id }}">{{trans('words.edit')}}</button>
                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="EditModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!-- form -->
                                    <form class="kt_form_1" enctype="multipart/form-data"
                                        action="{{ route('admin.coupons.update', ['id' => $item->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$item->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class=" form-group">
                                                    <label for="">{{ __('coupon.title') }}</label>
                                                    <input class="form-control "  required type="text"    placeholder="{{ __('coupon.title') }}" value="{{ $item->title }}" name="title">
                                                </div>
                                                <div class=" form-group">
                                                    
                                                    <label> {{ __('coupon.auto_generate_text') }}</label>
                                                    <input class="form-control "   type="text"   placeholder="{{ __('coupon.coupon') }}"  value="{{  $item->coupon }}" name="coupon">
                                                </div>
                                                <div class=" form-group">
                                                  <label for="">  {{ __('coupon.amount') }} </label>
                                                    <input class="form-control" type="number" min="0" required
                                                    placeholder="{{ __('coupon.amount') }}"  value="{{  $item->amount }}" name="amount">
                                                </div>
                                                <div class=" form-group">
                                                    <label for="">{{ __('coupon.limit') }}</label>
                                                    <input class="form-control" type="number" min="0" required
                                                    placeholder="{{ __('coupon.limit') }}"  value="{{  $item->limit }}" name="limit">
                                                </div>
                                                <div class=" form-group">
                                                    <label for="">{{ __('coupon.expire_date') }}</label>
                                                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off"
                                                    required type="text"   placeholder="{{ __('coupon.expire_date') }}"  value="{{ $item->expire_date }}" name="expire_date">
                                                </div>
                                       
                                                
                                                
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.edit')}}
                                                </button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <!--end::Modal-->
                            <x-buttons.but_delete_one link="{{route('admin.coupons.delete',['id'=>$item->id])}}" />

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>



@endsection