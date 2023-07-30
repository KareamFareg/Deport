@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css/>
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!-- search -->
  <div class="kt-portlet">
    <!-- <div class="kt-portlet__head"> -->
      <!-- <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          3 Columns Form Layout
        </h3>
      </div> -->
    <!-- </div> -->
      <div class="kt-portlet__body">
        <div class="form-group row">
          <div class="col-lg-12">
              &nbsp;&nbsp;&nbsp; <x-buttons.but_back link="{{ route('admin.users.index') }}"/>
              &nbsp;&nbsp;&nbsp; {{ __('subscription.title') }}
              <label class="">{{ $data->name ?? $data->phone }}</label>
              {{ $data->subscription_status ?
                __('subscription.rest').' : '.$data->subscription_status.' '.__('words.day').' - '.$data->subscription_end_date :
              __('subscription.ended') }}
          </div>

          </div>
        </div>
      </div>
    <!--end::Form-->






  <div class="kt-portlet kt-portlet--mobile">

     

    <div class="kt-portlet__body">
      <style>
      .dataTables_wrapper div.dataTables_filter { display: contents; }
      </style>


      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ __('subscription_package.title') }}</th>
            <th>{{ __('subscription_package.period') }}</th>
            <th>{{ __('subscription.code') }}</th>
            <th>{{ __('subscription.activated_date') }}</th>
            <th>{{ __('words.active') }}</th>
            <th>{{ __('subscription.rest') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data->subscriptions as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->subscriptionPackage->title }}</td>
            <td>{{ $item->subscriptionPackage->period }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->activated_date }}</td>
            <td>
              <form action="{{ route('admin.subscriptions.status',['id' => $item->id ]) }}" onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');"  enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                  <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                    <label>
                      <input type="checkbox"  {{ $item->is_active ? 'checked' : '' }}  onclick="submitForm(this);">
                      <span></span>
                    </label>
                  </span>
              </form>
            </td>
            <td>{{ $item->status }} {{ __('words.day') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!--end: Datatable -->
    </div>
  </div>
  </div>



@endsection




@section('js_pagelevel')
<x-admin.datatable.footer-js/>

<script>
function submitForm(me)
{
  $(me).closest("form").submit();
}
</script>

@endsection
