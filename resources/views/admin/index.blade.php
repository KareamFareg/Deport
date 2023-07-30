@extends('admin.layouts.master')

@section('content')

<!-- home page -->



<!-- general widgets -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <!--begin:: Widgets/Stats-->
  <div class="kt-portlet">

    <div class="kt-portlet__body  kt-portlet__body--fit">
      <div class="row row-no-padding row-col-separator-xl">

        <div class="col-md-12 col-lg-6 col-xl-4">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.clients') }}
                </h4>
                <p> <span class="kt-widget24__desc">
                    {{ __('words.active') }} : {{$clientCountActive}}
                  </span>
                </p>
                <p>
                  <span class="kt-widget24__desc">
                    {{ __('words.inactive') }} : {{$clientCountInActive}}
                  </span>
                </p>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{$clientCount}}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{$clientPercent}}%;"
                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-4">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.shippers') }}
                </h4>
                <p> <span class="kt-widget24__desc">
                    {{ __('words.active') }} : {{$shipperCountActive}}
                  </span>
                </p>
                <p>
                  <span class="kt-widget24__desc">
                    {{ __('words.inactive') }} : {{$shipperCountInActive}}
                  </span>
                </p>
              </div>
              <span class="kt-widget24__stats kt-font-warning">
                {{$shipperCount}}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-warning" role="progressbar" style="width: {{$shipperPercent}}%;"
                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-4">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.admins') }}
                </h4>
                <p> <span class="kt-widget24__desc">
                    {{ __('words.active') }} : {{$adminCountActive}}
                  </span>
                </p>
                <p>
                  <span class="kt-widget24__desc">
                    {{ __('words.inactive') }} : {{$adminCountInActive}}
                  </span>
                </p>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{$adminCount}}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{$adminPercent}}%;"
                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

          </div>
          <!--end::Total Profit-->
        </div>



      </div>

    </div>
  </div>
</div>


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


  <!--begin:: Widgets/Stats-->
  <div class="kt-portlet">
    <div class="kt-portlet__body  kt-portlet__body--fit">
      <div class="row row-no-padding row-col-separator-xl">
        <div class="col-xl-12 col-lg-12 order-lg-6 order-xl-1">
          <!--begin:: Widgets/Revenue Change-->
          <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
              <div class="kt-widget14__header">
                <h3 class="kt-widget14__title">
                  {{__('order.title')}} - {{__('order.chart')}}
                </h3>

                <dir class="row">

                  <div class=" form-group col-lg-2">
                    <label for="">{{__('commission.from')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" id="order_from" name="from">
                  </div>
                  <div class=" form-group col-lg-2">
                    <label for="">{{__('commission.to')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" id="order_to" name="to">
                  </div>
                  <div class="form-group col-lg-2">
                    <label for="">&nbsp;</label>
                    <button class="form-control btn btn-success " onclick="order_search()">
                      <i class=" flaticon flaticon2-search-1"></i>{{__('words.search')}}
                    </button>
                  </div>
                </dir>


              </div>
              <div class="kt-widget14__content" id="order_chart_div">

              </div>
            </div>
          </div>
          <!--end:: Widgets/Revenue Change-->
        </div>
      </div>
    </div>
  </div>



  <!--end:: Widgets/Stats-->

</div>

<!-- End general widgets -->
@php
$status=1;
@endphp
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('order.title').' - '. __("order.status_$status")  }}</label>
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
        <table class="table table-striped- table-bordered table-hover table-checkable deletable " id="kt_table_1">
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
              @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

              @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif
              @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

              @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
              <th>{{ __('words.order') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders1 as $item)
            <tr id="{{ $item->id }}">
              <td>
                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                  class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                  data-placement="right">
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

              <!-- error -->
              <td>{{-- $item->type_title() --}}</td>

              @if($status !=1 )
              <td>{{ optional($item->offer)->shipping }}</td>
              <td>{{ $item->price }}</td>
              <td>{{ $item->discount }}</td>
              <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount }}</td>
              @endif

              <td>{{ $item->created_at }}</td>
              @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
              @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->note }}</td>@endif
              @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif

              @if($status !=1 ) <td>
                <a class="btn btn-bold btn-label-brand btn-sm"
                  data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                  onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                  data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
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
            @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body" id="contact_us_details">

              </div>
            </div>
          </div>
        </div>
        <div id="err_contact_us_details"></div>

        <!--end: Datatable -->
      </div>
    </div>
  </div>
</div>

@php
$status=2;
@endphp
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('order.title').' - '. __("order.status_$status")  }}</label>
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
        <table class="table table-striped- table-bordered table-hover table-checkable deletable " id="kt_table_1">
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
              @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

              @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif
              @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

              @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
              <th>{{ __('words.order') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders2 as $item)
            <tr id="{{ $item->id }}">
              <td>
                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                  class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                  data-placement="right">
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
              <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount }}</td>
              @endif

              <td>{{ $item->created_at }}</td>
              @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
              @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->note }}</td>@endif
              @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif

              @if($status !=1 ) <td>
                <a class="btn btn-bold btn-label-brand btn-sm"
                  data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                  onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                  data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
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
            @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body" id="contact_us_details">

              </div>
            </div>
          </div>
        </div>
        <div id="err_contact_us_details"></div>

        <!--end: Datatable -->
      </div>
    </div>
  </div>
</div>


@php
$status=3;
@endphp
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('order.title').' - '. __("order.status_$status")  }}</label>
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
        <table class="table table-striped- table-bordered table-hover table-checkable deletable " id="kt_table_1">
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
              @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

              @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif
              @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

              @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
              <th>{{ __('words.order') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders3 as $item)
            <tr id="{{ $item->id }}">
              <td>
                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                  class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                  data-placement="right">
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
              <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount }}</td>
              @endif

              <td>{{ $item->created_at }}</td>
              @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
              @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->note }}</td>@endif
              @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif

              @if($status !=1 ) <td>
                <a class="btn btn-bold btn-label-brand btn-sm"
                  data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                  onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                  data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
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
            @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body" id="contact_us_details">

              </div>
            </div>
          </div>
        </div>
        <div id="err_contact_us_details"></div>

        <!--end: Datatable -->
      </div>
    </div>
  </div>
</div>


@php
$status=4;
@endphp
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('order.title').' - '. __("order.status_$status")  }}</label>
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
        <table class="table table-striped- table-bordered table-hover table-checkable deletable " id="kt_table_1">
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
              @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

              @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif
              @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

              @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
              <th>{{ __('words.order') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders4 as $item)
            <tr id="{{ $item->id }}">
              <td>
                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                  class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                  data-placement="right">
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
              <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount }}</td>
              @endif

              <td>{{ $item->created_at }}</td>
              @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
              @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->note }}</td>@endif
              @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif

              @if($status !=1 ) <td>
                <a class="btn btn-bold btn-label-brand btn-sm"
                  data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                  onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                  data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
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
            @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body" id="contact_us_details">

              </div>
            </div>
          </div>
        </div>
        <div id="err_contact_us_details"></div>

        <!--end: Datatable -->
      </div>
    </div>
  </div>
</div>




@php
$status=5;
@endphp
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('order.title').' - '. __("order.status_$status")  }}</label>
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
        <table class="table table-striped- table-bordered table-hover table-checkable deletable " id="kt_table_1">
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
              @if($status ==6 || $status ==5 )<th>{{ __('order.note') }}</th>@endif

              @if($status ==6 )<th>{{ __('words.order_status') }}</th>@endif
              @if($status !=1 )<th>{{__('words.rate')}}</th>@endif

              @if($status !=1 )<th>{{ __('words.chat') }}</th>@endif
              <th>{{ __('words.order') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orders5 as $item)
            <tr id="{{ $item->id }}">
              <td>
                <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}"
                  class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                  data-placement="right">
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
              <td>{{ $item->price  + optional($item->offer)->shipping - $item->discount }}</td>
              @endif

              <td>{{ $item->created_at }}</td>
              @if($status !=1 )<td>{{ $item->accept_date }}</td>@endif
              @if($status ==6 || $status ==4 )<td>{{ $item->delivery_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->cancel_date }}</td>@endif
              @if($status ==6 || $status ==5 )<td>{{ $item->note }}</td>@endif
              @if($status ==6 )<td>{{ $item->orderStatus() }}</td>@endif

              @if($status !=1 ) <td>
                <a class="btn btn-bold btn-label-brand btn-sm"
                  data-href="{{ route('admin.orders.rate' , [ 'id' => $item->id ] ) }}"
                  onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                  data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
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
            @endforeach
          </tbody>
        </table>

        <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body" id="contact_us_details">

              </div>
            </div>
          </div>
        </div>
        <div id="err_contact_us_details"></div>

        <!--end: Datatable -->
      </div>
    </div>
  </div>
</div>



<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <div class="kt-portlet kt-portlet--mobile">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <label for="" style="margin: 10px">{{ __('contact_us.title') }}</label>
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
            <th>{{ __('contact_us.name') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('words.type') }}</th>
            <th>{{ __('words.details') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.date') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($messages as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->type->title }}</td>
            <td>
              <a class="btn btn-bold btn-label-brand btn-sm"
                data-href="{{ route('admin.contacts.details' , [ 'id' => $item->id ] ) }}"
                onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal"
                data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
            </td>
            <td>{{ optional($item->user)->name }} - {{ optional($item->user)->phone }}</td>
            <td>{{ $item->created_at }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body" id="contact_us_details">

            </div>
          </div>
        </div>
      </div>
      <div id="err_contact_us_details"></div>

      <!--end: Datatable -->
    </div>
  </div>
</div>

@endsection



@section('js_pagelevel')

<script>
  window.onload = function() {
  gat_data('order_chart_div', '', 'get', "{{route('admin.order_chart')}}", '');

};


function order_search(){
  var from = $('#order_from').val();
  var to = $('#order_to').val();
  var data = 'from='+from+'&to='+to;

  gat_data('order_chart_div', '', 'get', "{{route('admin.order_chart')}}", data,null);

}
</script>

@endsection
