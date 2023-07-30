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

    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" action="{{ route('admin.subscriptions.index') }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <!-- <div class="col-lg-3">
            <label>{{ __('item.name') }}</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="col-lg-2">
                  <label class="">{{ __('subscription_package.name') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('subscription_packages_id') ? ' is-invalid' : '' }}" id="kt_select2_2" name="subscription_packages_id">
                    <option {{ old('subscription_packages_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $subscriptionPackages as $subscriptionPackage )
                      <option {{ old('subscription_packages_id') == $subscriptionPackage->id ? 'selected' : '' }} value="{{ $subscriptionPackage->id }}"> {{ $subscriptionPackage->title }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('subscription_packages_id'))
                      <span class="invalid-feedback">{{ $errors->first('subscription_packages_id') }}</span>
                  @endif
          </div>

          <div class="col-lg-2">
            <label>{{ __('words.active') }}</label>
            <x-active-status/>
          </div>
          <div class="col-lg-2">
            <label>{{ __('subscription.is_activated') }}</label>
            <x-is-activated/>
          </div>

          <div class="col-lg-2">
            <label>{{ __('client.title') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('user_id') ? ' is-invalid' : '' }}" id="kt_select2_3" name="user_id">
                    <option {{ old('category_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $users as $user )
                      <option {{ old('user_id') == $user->id ? 'selected' : '' }} value="{{ $user->id }}"> {{ $user->name }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('user_id'))
                      <span class="invalid-feedback">{{ $errors->first('user_id') }}</span>
                  @endif
          </div>


          <div class="col-lg-4">
            <label>.</label>
            <div class="input-group"><x-buttons.but_agree/><x-buttons.but_delete link='aaaa'/></div>

          </div>
        </div>
      </div>

    </form>

    <!--end::Form-->
  </div>






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
            <th>{{ __('subscription.code') }}</th>
            <th>{{ __('subscription_package.name') }}</th>
            <th>{{ __('auth.name') }}</th>
            <th>{{ __('subscription.is_activated') }}</th>
            <th>{{ __('subscription.activated_date') }}</th>
            <th>{{ __('words.active') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>
            <a class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right">
              {{ $item->code }}
            </a>
            </td>
            <td>{{ $item->subscriptionPackage->title }}</td>
            <td>{{ optional($item->user)->name }}</td>
            <td>{{ $item->is_activated }}</td>
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
