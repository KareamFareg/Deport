@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css />
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

        <div class="kt-portlet__body">
        <form class="kt_form_1 row" enctype="multipart/form-data" action="{{route(request()->route()->getName(),['id'=>$id])}}"
                method="post">
                {{ csrf_field() }}
            
                <div class=" form-group col-lg-2">
                    <label for="">{{__('words.order_status')}}</label>
                    <select class="form-control kt-select2 " id="kt_select2_3" name="status">
                        <option value="0"> {{ __('order.status_6') }}</option>
                        <option value="1"> {{ __('order.status_1') }}</option>
                        <option value="2"> {{ __('order.status_2') }}</option>
                        <option value="3"> {{ __('order.status_3') }}</option>
                        <option value="4"> {{ __('order.status_4') }}</option>
                        <option value="5"> {{ __('order.status_5') }}</option>
                    </select>
                </div>

                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.from')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" value="{{$from ?? ''}}" name="from">
                </div>
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.to')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" value="{{$to ?? ''}}" name="to">
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
                        <label for=""
                            style="margin: 10px">{{ __('order.title').' / '. $subTitle  }}</label>
                        {{-- <x-buttons.but_delete_list link="{{route('admin.orders.deleteOrders')}}" /> --}}
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
            <div class="table-responsive">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable deletable "
                    id="kt_table_1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('order.client') }}</th>
                            @if($status !=1 ) <th>{{ __('order.shipper') }}</th>@endif

                            <th>{{ __('order.type') }}</th>

                            @if($status !=1 )
                            <th>{{ __('order.shipping') }}</th>
                            <th>{{ __('order.total_first') }}</th>
                            <th>{{ __('order.discount') }}</th>
                            <th>{{ __('order.total') }}</th>
                            @endif

                            <th>{{ __('order.created_at') }}</th>
                            @if($status !=1 )<th>{{ __('order.accept_date') }}</th>@endif
                            @if($status ==6 || $status ==4 )<th>{{ __('order.delivery_date') }}</th>@endif
                            @if($status ==6 || $status ==5 )<th>{{ __('order.cancel_date') }}</th>@endif

                            @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif


                            @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
                            <th>{{ __('words.order') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr id="{{ $item->id }}">
                            <td>
                                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                                    class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5"
                                    data-toggle="kt-tooltip" data-placement="right">
                                    {{ $item->code }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.clients.edit', [ 'id' => optional($item->user_data)->id ] ) }}">
                                    {{ optional($item->user_data)->name }}
                                </a>
                            </td>

                            @if($status !=1 )
                            <td>
                                @if (isset($item->shipper_data))
                                <a
                                    href="{{ route('admin.shippers.edit', [ 'id' => optional($item->shipper_data)->id ] ) }}">
                                    {{ optional($item->shipper_data)->name }}
                                </a>
                                @endif
                            </td>
                            @endif


                            <td>{{ $item->type_title() }}</td>

                            @if($status !=1 )
                            <td>{{ optional($item->offer)->shipping }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->price  + optional($item->offer)->shipping + $item->commission}}</td>
                            @endif

                            <td>{{ $item->created_at }}</td>
                            @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
                            @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
                            @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
                            @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif
                            
                            
                            @if($status !=1 )
                            <td>
                                <x-buttons.but_link link="{{ route('admin.chat.order' , [ 'id' => $item->id ] ) }}"
                                    title="{{ __('words.preview') }}" />
                            </td>
                            @endif
                            <td>
                                <x-buttons.but_link link="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                                    title="{{ __('words.details') }}" />
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


@endsection




@section('js_pagelevel')
<x-admin.datatable.footer-js />

<script>
    function submitForm(me)
{
  $(me).closest("form").submit();
}

</script>

@endsection