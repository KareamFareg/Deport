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
    <form class="kt-form kt-form--label-right" action="{{ route('admin.items.index_air') }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <!-- <div class="col-lg-3">
            <label>{{ __('item.name') }}</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="col-lg-3">
                  <label class="">{{ __('item.from_country') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('from_country_id') ? ' is-invalid' : '' }}" id="kt_select2_3" name="from_country_id">
                    <option {{ old('from_country_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $countries as $country )
                      <option {{ old('from_country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}"> {{ $country->title }} {{str_repeat('__', $country->depth ?? 0)}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('from_country_id'))
                      <span class="invalid-feedback">{{ $errors->first('from_country_id') }}</span>
                  @endif
          </div>

          <div class="col-lg-3">
                  <label class="">{{ __('item.to_country') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('to_country_id') ? ' is-invalid' : '' }}" id="kt_select2_2" name="to_country_id">
                    <option {{ old('to_country_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $countries as $country )
                      <option {{ old('to_country_id') == $country->id ? 'selected' : '' }} value="{{ $country->id }}"> {{ $country->title }} {{str_repeat('__', $country->depth ?? 0)}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('to_country_id'))
                      <span class="invalid-feedback">{{ $errors->first('to_country_id') }}</span>
                  @endif
          </div>

          <div class="col-lg-2">
            <label>{{ __('words.active') }}</label>
            <x-active-status/>
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
            <th>{{ __('item.from_country') }}</th>
            <th>{{ __('item.to_country') }}</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.time') }}</th>
            <th>{{ __('item.package_count') }}</th>
            <th>{{ __('words.active') }}</th>
            <th>{{ __('user.name') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>
              {{--<a href="{{ route('admin.items.edit' , [ 'id' => $item->id ] ) }}" class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right"></a>--}}
              {{ $item->id }}
            </td>
            <td>{{ !($item->countryFrom->translation->isEmpty()) ? $item->countryFrom->translation->first()->title : ''}}</td>
            <td>{{ !($item->countryTo->translation->isEmpty()) ? $item->countryTo->translation->first()->title : ''}}</td>
            <td>{{ $item->_date }}</td>
            <td>{{ $item->_time }}</td>
            <td>{{ $item->package_count }}</td>
            <td>
              <form action="{{ route('admin.items.status',['id' => $item->id ]) }}" onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');"  enctype="multipart/form-data" method="post">
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
            <td>{{ $item->user->name }} - {{ $item->user->phone }}</td>
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
