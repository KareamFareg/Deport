@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css />
@endsection


@section('content')




<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

        <div class="kt-portlet__body">
            
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
                            style="margin: 10px">{{ __('order.title').' / '. __("order.status_$status")  }}</label>
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
                <table class="table table-striped- table-bordered table-hover table-checkable  "
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
                            @if($status ==6 || $status ==5 )<th>{{ __('order.canceled_by') }}</th>@endif
                            @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

                            @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif

                            @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

                            @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
                            <th>{{ __('words.order') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $shipping=0;
                        $order=0;
                        $discount=0;
                        $total=0;
                        @endphp
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
                                @if($item->user_data)
                                <a href="{{ route('admin.clients.edit', [ 'id' => optional($item->user_data)->id ] ) }}">
                                  {{ optional($item->user_data)->name }}
                                </a>
                                @else
                                @lang('words.deleted')
                                @endif
                
                              </td>
                
                              @if($status !=1 )
                              <td>
                                @if (isset($item->shipper_data))
                                <a href="{{ route('admin.shippers.edit', [ 'id' => optional($item->shipper_data)->id ] ) }}">
                                  {{ optional($item->shipper_data)->name }}
                                </a>
                                @else
                                @lang('words.deleted')
                                @endif
                              </td>
                              @endif


                            <td>{{ $item->type_title() }}</td>

                            @if($status !=1 )
                            <td>{{ optional($item->offer)->shipping }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount + $item->commission }}</td>
                            @endif

                            <td>{{ $item->created_at }}</td>
                            @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
                            @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
                            @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
                            @if($status ==6 || $status ==5 )<td>
                                @if($item->canceld_by == 1){{ __('order.user') }} @elseif($item->canceld_by == 2) {{ __('order.shipper') }} @elseif($item->canceld_by == 3) {{ __('order.management') }} @endif

                            </td>@endif
                            @if($status ==6 || $status ==5 )<td><a class="btn btn-bold btn-label-brand btn-sm"
                                   
                                data-toggle="modal"
                        data-target="#canceled_details_{{$item->id}}">{{ __('words.details') }}</a>
                        
                        <div class="modal fade" id="canceled_details_{{$item->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body" >
                                    {{ $item->note }}
                                </div>
                            </div>
                        </div>
                    </div></td>@endif
                            @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif


                            @if($status !=1 ) <td>
                                <a class="btn btn-bold btn-label-brand btn-sm"
                                    data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                                    onclick="ajaxlink(event,this,'rate_details','err_rate_details','');"
                                    data-toggle="modal"
                                    data-target="#modal_rate_details">{{ __('words.details') }}</a>
                            </td>@endif
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
                        @php
                        $shipping+=optional($item->offer)->shipping ;
                        $order+= $item->price;
                        $discount+=$item->discount ;
                        $total+=$item->price + optional($item->offer)->shipping - $item->discount;
                        @endphp
                        @endforeach
                    </tbody>

                    <tfoot>
                        <th>الاجمالى</th>
                        <th></th>
                        @if($status !=1 ) <th></th>@endif
                        <th></th>
                        @if($status !=1 )
                        <th>{{  $shipping }}</th>
                        <th>{{ $order}}</th>
                        <th>{{ $discount }}</th>
                        <th>{{ $total }}</th>
                        @endif
                        <th></th>
                        @if($status !=1 )<th></th>@endif
                        @if($status ==6 || $status ==4 )<th></th>@endif
                        @if($status ==6 || $status ==5 )<th></th>@endif
                        @if($status ==6 || $status ==5 )<th></th>@endif
                        @if($status ==6 )<th></th>@endif
                        @if($status !=1 )<th></th>@endif
                        @if($status !=1 )<th></th>@endif
                        <th></th>
                    </tfoot>
                </table>

                <div class="modal fade" id="modal_rate_details" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body" id="rate_details">

                            </div>
                        </div>
                    </div>
                </div>
                <div id="err_rate_details"></div>

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