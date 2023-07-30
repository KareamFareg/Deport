@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            @php $backRouteName="admin.$typeName.index" @endphp
                            <x-buttons.but_back link="{{ route($backRouteName) }}" />
                            @if($type != 1)

                            @php $ordersRouteName="admin.$typeName.orders" @endphp
                            <x-buttons.but_link link="{{ route($ordersRouteName, [ 'id' => $user->id ] ) }}"
                                title="{{ __('order.title') }}" />

                            @php $rateRouteName="admin.$typeName.rate" @endphp
                            <x-buttons.but_link link="{{ route($rateRouteName, [ 'id' => $user->id ] ) }}"
                                title="{{ __('words.rate') }}" />


                            @endif


                        </h3>
                    </div>
                </div>




                <div class="kt-portlet__body">
                    <table class="table table-striped- table-bordered table-hover table-checkable ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('order.rate') }} </th>
                                <th> {{ __('order.order_comment') }}</th>
                                <th>{{ __('words.order') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            <tr>
                                <td>{{$rate->id}}</td>
                                <td>
                                    @php
                                    for ($x = 1; $x <= $rate->rate; $x++) {
                                        echo ' <i style="color: gold" class="fa fa-star"></i> '; }
                                    @endphp
                                </td>
                                <td> {{$rate->comment}}</td>
                                <td>
                                    <x-buttons.but_link
                                        link="{{ route('admin.orders.show' , [ 'id' => $rate->order_id ] ) }}"
                                        title="{{ __('words.details') }}" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>



@section('js_pagelevel')
<x-admin.dropify-js />
@endsection

@endsection