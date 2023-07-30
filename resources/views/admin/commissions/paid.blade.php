@extends('admin.layouts.master')
@section('css_pagelevel')
<x-admin.datatable.header-css />

<style>
    .dataTables_wrapper div.dataTables_filter {
        display: contents;
    }
</style>

@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

        <div class="kt-portlet__body">
            <form class="kt_form_1 row" enctype="multipart/form-data" action="{{ route('admin.commission.paid') }}"
                method="post">
                {{ csrf_field() }}
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.shipper')}}</label>
                    <select class="form-control kt-select2 " id="kt_select2_3" name="shipper">
                        <option value="0"> {{ __('commission.all_shippers') }}</option>
                        @foreach ( \App\User::Info()->where('type_id',3)->get() as $user)
                        <option @if($user->id == $shipper) selected @endif  value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
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
                        <th>{{ __('commission.shipper') }}</th>
                        <th>{{ __('commission.orders_price') }}</th>
                        <th>{{ __('commission.shipping_price') }}</th>
                        {{-- <th>{{ __('commission.shipper_amount') }}</th> --}}
                        <th>{{ __('commission.commissions') }}</th>
                        <th>{{ __('commission.discounts') }}</th>
                        <th>{{ __('commission.cash') }}</th>
                        <th>{{ __('commission.walet') }}</th>
                        <th>{{ __('commission.online') }}</th>
                        <th>{{ __('commission.charge_wallet') }}</th>

                        <th>{{ __('commission.deserved_amount') }}</th>


                    </tr>
                </thead>
                <tbody>
                    @php
                    $totalOrderPrice =0;
                    $totalShippingPrice =0;
                    $totalCommission =0;
                    $totalDiscount =0;
                    $totalCash =0;
                    $totalWalet =0;
                    $totalOnline =0;
                    $totalcharge_wallet =0;

                    $totalDesevedMore =0;
                    @endphp
                    @foreach ($shippers as $shipper)
                    <tr>
                        <td>{{ $shipper->id }}</td>
                        <td>{{ $shipper->name }}</td>
                        <td>{{ $shipper->orders_price($ordersIds, 1) }}</td>
                        <td>{{ $shipper->shipping_price($ordersIds, 1) }}</td>
                        {{-- <td>{{ $shipper->shipper_amount($ordersIds, 0) }}</td> --}}
                        <td>{{ $shipper->commission($ordersIds, 1) }} ريال </td>
                        <td>{{ $shipper->discount($ordersIds, 1) }} ريال </td>
                        <td>{{ $shipper->payment($ordersIds,1, 1) }} ريال </td>
                        <td>{{ $shipper->payment($ordersIds,2, 1) }} ريال </td>
                        <td>{{ $shipper->payment($ordersIds,3, 1) }} ريال </td>
                        <td>{{ $shipper->charge_wallet($ordersIds, 0) }} ريال  </td>

                        <td>{{ $shipper->deserved_amount($ordersIds, 1) }} ريال </td>
                    </tr>
                    @php
                    $totalOrderPrice += $shipper->orders_price($ordersIds, 1);
                    $totalShippingPrice += $shipper->shipping_price($ordersIds, 1);
                    $totalCommission += $shipper->commission($ordersIds, 1);
                    $totalDiscount += $shipper->discount($ordersIds, 1);
                    $totalCash += $shipper->payment($ordersIds,1, 1);
                    $totalWalet += $shipper->payment($ordersIds,2, 1);
                    $totalOnline += $shipper->payment($ordersIds,3, 1);
                    $totalcharge_wallet += $shipper->charge_wallet($ordersIds, 0);

                    $totalDesevedMore += $shipper->deserved_amount($ordersIds, 1);
                    @endphp
                    @endforeach
                </tbody>
                <tfoot style="font-weight: 600;">
                    <th>الاجمالى</th>
                    <th></th>
                    <th>{{$totalOrderPrice}}</th>
                    <th>{{$totalShippingPrice}}</th>
                    <th>{{$totalCommission}}</th>
                    <th>{{$totalDiscount}}</th>
                    <th>{{$totalCash}}</th>
                    <th>{{$totalWalet}}</th>
                    <th>{{$totalOnline}}</th>
                    <th>{{$totalcharge_wallet}}</th>

                    <th>{{$totalDesevedMore}}</th>

                </tfoot>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>


@endsection


@section('js_pagelevel')
<x-admin.datatable.footer-js />



@endsection