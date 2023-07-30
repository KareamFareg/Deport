@extends('admin.layouts.master')

@section('content')

<!-- <a class="btn btn-secondary buttons-csv buttons-html5" id="printPdf" name="printPdf" >pdf</a>  -->
<!--onclick='printPdf();'-->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid" id="main_div">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <div class="row">
                 {{ __('order.order_id') }}&nbsp;:&nbsp;{{ $data->id }} &nbsp;&nbsp;/&nbsp;&nbsp;
                 {{ __('words.date') }}&nbsp;:&nbsp;{{ $data->created_at }} &nbsp;&nbsp;/&nbsp;&nbsp;
                 {{ __('words.order_status') }}&nbsp;:&nbsp;{{ Arr::get($orderStatus,$data->status) }}
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">



    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('words.ip') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->ip }}</label>
      </div>
    </div>



    <!---------------------->

    @if (isset($data->paytype))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('order.paytype') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->paytype }}</label>
      </div>
    </div>
    @endif


    @if (isset($data->deliverytype))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('order.deliverytype') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->deliverytype }}</label>
      </div>
    </div>
    @endif


    @if (isset($data->delivery_mount))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('order.delivery_mount') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->delivery_mount }}</label>
      </div>
    </div>
    @endif


    @if (isset($data->lat))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12"></label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->lat }}</label>
      </div>
    </div>
    @endif

    @if (isset($data->lng))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12"></label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->lng }}</label>
      </div>
    </div>
    @endif


    @if (isset($data->total_first))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('order.total_first') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->total_first }}</label>
      </div>
    </div>
    @endif

    @if (isset($data->total))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('order.total') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">{{ $data->total }}</label>
      </div>
    </div>
    @endif

    @if (isset($data->shop))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('client.title') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">
          <a href="{{ route('admin.clients.edit', [ 'id' => $data->shop->client->id ] ) }}">
            {{  !$data->shop->client->client_info->isEmpty() ? $data->shop->client->client_info->first()->title : $data->shop->client->title_general }}</a>
        </label>
      </div>
    </div>
    @endif

    @if (isset($data->accept))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('user.accept') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">
          {{--<a href="{{ route('admin.users.edit', [ 'id' => $data->accept->id ] ) }}">
            {{ $data->accept->name }}</a>--}}
            {{ $data->accept->name }}
        </label>
      </div>
    </div>
    @endif

    @if (isset($data->user))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('user.user') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        <label class="col-form-label col-lg-12 col-sm-12">
          <a href="{{ route('admin.users.edit', [ 'id' => $data->user->id ] ) }}">
            {{ $data->user->name }} - {{ $data->user->phone }}</a>
        </label>
      </div>
    </div>
    @endif

    @if (isset($data->orderStatus))
    <div class="form-group row">
      <label class="col-form-label col-lg-2 col-sm-12">{{ __('words.order_status') }}</label>
      <div class=" col-lg-8 col-md-9 col-sm-12">
        @foreach ($data->orderStatus as $orderSt)
        <label class="col-form-label col-lg-12 col-sm-12">
          <a href="{{ route('admin.users.edit', [ 'id' => $orderSt->user->id ] ) }}">
            {{ $orderSt->user->name }} - {{ $orderSt->user->phone }} - {{ Arr::get($orderStatus,$orderSt->status) }} - {{ $orderSt->created_at }}</a>
        </label>
        @endforeach
      </div>
    </div>
    @endif

    @if ($data->order_type_id == 1)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
      <thead>
        <tr>
          <th>ID</th>
          <th>{{ __('item.name') }}</th>
          <th>{{ __('words.price') }}</th>
          <th>{{ __('words.description') }}</th>
          <th>{{ __('words.from') }}</th>
          <th>{{ __('words.to') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->items as $item)
        <tr id="{{ $item->id }}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->item_title }}</td>
          <td>{{ $item->price }}</td>
          <td>{{ $item->description }}</td>
          <td>{{ $item->from_lat }} {{ $item->from_lng }}</td>
          <td>{{ $item->to_lat }} {{ $item->to_lng }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    @if ($data->order_type_id == 2)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
      <thead>
        <tr>
          <th>ID</th>
          <th>{{ __('words.description') }}</th>
          <th>{{ __('words.count') }}</th>
          <th>{{ __('words.date') }}</th>
          <th>{{ __('car_type.title') }}</th>
          <th>{{ __('car_brand.title') }}</th>
          <th>{{ __('item.model') }}</th>
          <th>{{ __('words.from') }}</th>
          <th>{{ __('words.to') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->items as $item)
        <tr id="{{ $item->id }}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->item_title }}</td>
          <td>{{ $item->_count }}</td>
          <td>{{ $item->_date }}</td>
          <td>{{ $item->car_type }}</td>
          <td>{{ $item->car_brand }}</td>
          <td>{{ $item->car_model }}</td>
          <td>{{ $item->from_lat }} {{ $item->from_lng }}</td>
          <td>{{ $item->to_lat }} {{ $item->to_lng }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    @if ($data->order_type_id == 3)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
      <thead>
        <tr>
          <th>ID</th>
          <th>{{ __('words.price') }}</th>
          <th>{{ __('words.from') }}</th>
          <th>{{ __('words.to') }}</th>
          <th>{{ __('words.date') }}</th>
          <th>{{ __('words.time') }}</th>
          <th>{{ __('words.description') }}</th>
          <th>{{ __('words.identity_no') }}</th>
          <th>{{ __('item.package_image') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->items as $item)
        <tr id="{{ $item->id }}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->price }}</td>
          <td>{{ $item->from_place }}</td>
          <td>{{ $item->to_place }}</td>
          <td>{{ $item->_date }}</td>
          <td>{{ $item->_time }}</td>
          <td>{{ $item->description }}</td>
          <td>{{ $item->identity_no }}</td>
          <td>{{ $item->package_image }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    @if ($data->order_type_id == 4)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
      <thead>
        <tr>
          <th>ID</th>
          <th>{{ __('package_type.title') }}</th>
          <th>{{ __('car_type.title') }}</th>
          <th>{{ __('car_brand.title') }}</th>
          <th>{{ __('user.car_model') }}</th>
          <th>{{ __('package_type.name') }}</th>
          <th>{{ __('order.weight') }}</th>
          <th>{{ __('words.from') }}</th>
          <th>{{ __('words.to') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->items as $item)
        <tr id="{{ $item->id }}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->title }}</td>
          <td>{{ $item->car_type }}</td>
          <td>{{ $item->car_brand }}</td>
          <td>{{ $item->car_model }}</td>
          <td>{{ $item->package_type }}</td>
          <td>{{ $item->weight }}</td>
          <td>{{ $item->from_lat }} {{ $item->from_lng }}</td>
          <td>{{ $item->to_lat }} {{ $item->to_lng }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif

    @if ($data->order_type_id == 5)
    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
      <thead>
        <tr>
          <th>ID</th>
          <th>{{ __('car_type.title') }}</th>
          <th>{{ __('order.weight') }}</th>
          <th>{{ __('order.transport_type') }}</th>
          <th>{{ __('order.material_type') }}</th>
          <th>{{ __('car_type.title') }}</th>
          <th>{{ __('words.from') }}</th>
          <th>{{ __('words.to') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data->items as $item)
        <tr id="{{ $item->id }}">
          <td>{{ $item->id }}</td>
          <td>{{ $item->title }}</td>
          <td>{{ $item->weight }}</td>
          <td>{{ $item->transport_type }}</td>
          <td>{{ $item->material_type }}</td>
          <td>{{ $item->car_type }}</td>
          <td>{{ $item->from_lat }} {{ $item->from_lng }}</td>
          <td>{{ $item->to_lat }} {{ $item->to_lng }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif






          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@section('js_pagelevel')
<x-admin.dropify-js/>
<x-admin.export-pdf divToPrint="main_div"/>
@endsection

@endsection
