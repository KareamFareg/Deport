@extends('admin.layouts.master')

@section('content')


<style>
    .invoice-logo {
        /* display: none; */
    }

    @media print {
        .print-left {
            float: left;
        }

        .print-right {
            float: right;
        }

        .header,
        aside,
        head .site-footer,
        .print-hide,
        .kt-aside__brand,
        .kt-header-mobile,
        .kt-subheader,
        .kt_header,
        .kt-header__topbar,
        title,
        .kt-footer__copyright {
            display: none;
        }



        .content,
        .invoice-logo {
            visibility: visible;
            position: absolute;
            margin: 0px;
            width: 100%;
            padding: 0px;
        }

        @page {
            size: auto;
            margin-bottom: 5mm;
        }

        #Header,
        #Footer {
            display: none !important;
        }

    }
</style>

<div class="col-xl-12 col-lg-12">

    <!--begin:: Widgets/Sale Reports-->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head ">
            <div class="kt-portlet__head-label ">
                <h3 class="kt-portlet__head-title">
                    <div class="row print-hide">
                        <a class="btn btn-warning " style="margin: 10px" onclick="print()"><i class="icon-print"></i>
                            طباعة </a>
                        <a class="btn btn-success" style="margin: 10px" id="printPdf"><i class="icon-print"></i> PDF
                        </a>
                        @if($data->status == 1 )
                        <button style="margin: 10px" type="button" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#accept">تم القبول</button>
                        <!--begin:: Edit Modal-->
                        <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- form -->
                                <form class="kt_form_1" enctype="multipart/form-data"
                                    action="{{ route('admin.orders.accept',['id'=>$data->id ]) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <textarea name="note" required placeholder="{{ __('order.note') }}"
                                                    class="form-control" rows="5"></textarea>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.send')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @endif
                        @if($data->status == 1 || $data->status == 2)
                        
                        <button style="margin: 10px" type="button" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#onway"> جاري التوصيل</button>
                        <!--begin:: Edit Modal-->
                        <div class="modal fade" id="onway" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- form -->
                                <form class="kt_form_1" enctype="multipart/form-data"
                                    action="{{ route('admin.orders.onway',['id'=>$data->id ]) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <textarea name="note" required placeholder="{{ __('order.note') }}"
                                                    class="form-control" rows="5"></textarea>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.send')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        @if($data->status == 1 || $data->status == 2 || $data->status == 3)
                            <button style="margin: 10px" type="button" class="btn btn-outline-danger" data-toggle="modal"
                                data-target="#done">تم التوصيل</button>

                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="done" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!-- form -->
                                    <form class="kt_form_1" enctype="multipart/form-data"
                                        action="{{ route('admin.orders.complete',['id'=>$data->id ]) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class=" form-group">
                                                    <textarea name="note" required placeholder="{{ __('order.note') }}"
                                                        class="form-control" rows="5"></textarea>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{__('words.cancel')}}</button>
                                                    <button class=" btn btn-success " type="submit">
                                                        <i class="fa fa-plus"></i>{{__('words.send')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!--end::Modal-->
                        @endif
                        @if($data->status == 1 || $data->status == 2)
                        <button style="margin: 10px" type="button" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#Add">{{trans('order.cancel_order')}}</button>
                        <!--begin:: Edit Modal-->
                        <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- form -->
                                <form class="kt_form_1" enctype="multipart/form-data"
                                    action="{{ route('admin.orders.cancel',['id'=>$data->id ]) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <textarea name="note" required placeholder="{{ __('order.note') }}"
                                                    class="form-control" rows="5"></textarea>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.send')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Modal-->
                        @endif
                    </div>
                </h3>
            </div>
        </div>


        <div class="kt-portlet__body" id="content">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="main_div">
                <tbody>
                    {{-- <tr class="invoice-logo">
                        <td>
                            <img src="{{ $settings['logo'] }}" class="img-fluid mx-auto" alt="logo">

                    </td>
                    </tr> --}}
                    <tr>
                        <td>{{ __('order.info') }}</td>
                        <td>
                            <ul>
                                <li>{{ __('order.order_id') }}&nbsp;:&nbsp;{{ $data->code }} </li>
                                <li>{{ __('words.date') }}&nbsp;:&nbsp;{{ $data->created_at }} </li>
                                @if($data->status != 1) <li>
                                    {{ __('order.accept_date') }}&nbsp;:&nbsp;{{ $data->accept_date }} </li> @endif
                                <li>{{ __('words.order_status') }}&nbsp;:&nbsp;{{ $data->orderStatus() }}
                                    @if($data->status == 4) {{$data->delivery_date}} @endif
                                    @if($data->status == 5) {{$data->cancel_date}} @endif
                                </li>
                                <li>{{ __('words.type') }}&nbsp;:&nbsp;{{ $data->type_title() }}</li>
                                <li>{{ __('order.paytype') }}&nbsp;:&nbsp;{{ $data->orderPayment() }}</li>

                            </ul>



                        </td>
                    </tr>
                    @if ($data->invoice)
                    <tr>
                        <td>{{ __('order.invoice') }}</td>
                        <td>
                            <span class="tooltips" data-toggle="modal" data-target="#invoice" style="  cursor: pointer">

                                <img src="{{ asset('storage/app/' . $data['invoice']) }}" style="max-height : 100px"
                                    class="  img-responsive img-thumbnail img-rounded">
                            </span>

                            <div class="modal  fade" id="invoice" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered ">
                                    <div class="modal-content">

                                        <div class="modal-content">
                                            <div class="modal-body" style=" text-align: center;">
                                                <img style="width : 100% "
                                                    src="{{asset('storage/app/' . $data['invoice'])}}"
                                                    class="  img-responsive ">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>{{ __('words.address') }}</td>
                        <td>
                            <div id="map_from_to" style="height: 300px ;width:100% " class="map"
                                lat="{{ $data->source_lat }}" lng="{{ $data->source_lng }}"
                                lat2="{{ $data->destination_lat }}" lng2="{{ $data->destination_lng }}"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>{{ __('order.shipping') }}</td>
                        <td>{{ $data->shipping - $data->commission }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('order.discount') }}</td>
                        <td>{{  floatval($data->discount) }} &nbsp;&nbsp;/&nbsp;&nbsp;
                            {{ __('order.coupon') ." : ". $data->coupon}} </td>
                    </tr>
                     <tr>
                        <td>{{ __('commission.commissions') }}</td>
                        <td>{{  floatval($data->commission) }} </td>
                    </tr>
                    <tr>
                        <td>{{ __('commission.addition_service') }}</td>
                        <td>{{  floatval($data->addition_service_cost) }} </td>
                    </tr>
                    <tr>
                        <td>{{ __('order.total_first') }}</td>
                        <td>{{  $data->price }}</td>
                    </tr>

                    <!-- <tr>
                        <td>{{ __('order.total') }}</td>
                        <td>{{ $data->price + optional($data->offer)->shipping - floatval($data->discount)+floatval($data->commission)  }}</td>
                    </tr> -->
                    <tr>
                        <td>{{ __('order.total') }}</td>
                        <td>{{ $data->price + $data->shipping + $data->addition_service_cost -  floatval($data->discount) }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('order.user') }}</td>
                        <td>

                            <ul>
                                <li>
                                    @if($data->user_data)
                                    <a
                                        href="{{ route('admin.clients.edit', [ 'id' => optional($data->user_data)->id ] ) }}">
                                        {{ optional($data->user_data)->name }}
                                    </a>
                                    @else
                                    @lang('words.deleted')
                                    @endif
                                </li>


                            </ul>


                        </td>

                    </tr>

                    <tr>
                        <td>{{ __('order.shipper') }}</td>
                        <td>
                            <ul>
                                <li>
                                    @if (isset($data->shipper_data))
                                    <a
                                        href="{{ route('admin.shippers.edit', [ 'id' => optional($data->shipper_data)->id ] ) }}">
                                        {{ optional($data->shipper_data)->name }}
                                    </a>
                                    @else
                                    @lang('words.deleted')
                                    @endif
                                </li>


                            </ul>
                        </td>
                    </tr>

                    <tr>
                        <td>{{ __('order.comment') }}</td>
                        <td>{{ $data->comment }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('order.note') }}</td>
                        <td>{{ $data->note }} </td>
                    </tr>


                    <tr>
                        <td>{{ __('order.title') }}</td>
                        <td>
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                id="kt_table_2">
                                <thead>
                                    <tr>
                                        <th>{{ __('words.name') }}</th>
                                        <th>{{ __('words.image') }}</th>
                                        <th>{{ __('words.quantity') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->items as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>

                                        <td><img src="{{ asset('storage/app/' . $item['image']) }}"
                                                style="max-width: 150px;">
                                        </td>
                                        <td>{{ $item-> quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @if($data->addition_service == 1 )
                    <tr>
                        <td>{{ __('order.addition_items') }}</td>
                        <td>
                            <table class="table table-striped- table-bordered table-hover table-checkable"
                                id="kt_table_2">
                                <thead>
                                    <tr>
                                        <th>{{ __('words.name') }}</th>
                                        <th>{{ __('words.image') }}</th>
                                        <th>{{ __('words.quantity') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->addition_items as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>

                                        <td><img src="{{ asset('storage/app/' . $item['image']) }}"
                                                style="max-width: 150px;">
                                        </td>
                                        <td>{{ $item-> quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif


                </tbody>
            </table>

        </div>
    </div>
</div>


@section('js_pagelevel')

<x-admin.export-invoice url="{{ route('admin.orders.pdf' , [ 'id' =>  $data->id ] ) }}" />
<x-admin.print-content />
<x-admin.google-map-multi-js />
@endsection

@endsection