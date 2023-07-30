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
    <form class="kt-form kt-form--label-right" action="{{ route('admin.items.index_transport') }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <!-- <div class="col-lg-3">
            <label>{{ __('item.name') }}</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="col-lg-3">
                  <label class="">{{ __('car_brand.title') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('car_brand_id') ? ' is-invalid' : '' }}" id="kt_select2_3" name="car_brand_id">
                    <option {{ old('car_brand_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $carBrands as $carBrand )
                      <option {{ old('car_brand_id') == $carBrand->id ? 'selected' : '' }} value="{{ $carBrand->id }}"> {{ optional($carBrand->car_brand_info->first())->title }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('car_brand_id'))
                      <span class="invalid-feedback">{{ $errors->first('car_brand_id') }}</span>
                  @endif
          </div>

          <div class="col-lg-3">
                  <label class="">{{ __('car_type.title') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('car_type_id') ? ' is-invalid' : '' }}" id="kt_select2_2" name="car_type_id">
                    <option {{ old('car_type_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $carTypes as $carType )
                      <option {{ old('car_type_id') == $carType->id ? 'selected' : '' }} value="{{ $carType->id }}"> {{ optional($carType->car_type_info->first())->title }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('car_type_id'))
                      <span class="invalid-feedback">{{ $errors->first('car_type_id') }}</span>
                  @endif
          </div>

          {{--
          <div class="col-lg-3">
                  <label class="">{{ __('category.title') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_5" name="category_id">
                    <option {{ old('category_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                    @foreach ( $categories as $category )
                      <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth ?? 0)}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('category_id'))
                      <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                  @endif
          </div>
          --}}

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
            <th>{{ __('car_brand.title') }}</th>
            <th>{{ __('car_type.title') }}</th>
            <th>{{ __('item.model') }}</th>
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
            <td>{{ optional($item->carBrand->translation->first())->title }}</td>
            <td>{{ optional($item->carType->translation->first())->title }}</td>
            <td>{{ $item->car_model }}</td>
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
