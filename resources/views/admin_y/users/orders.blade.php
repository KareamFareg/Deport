@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css/>
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!-- search -->

  <div class="kt-portlet">


    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          {{ $user->id }} - {{ $user->name }} - {{ $user->phone }}
        </h3>
      </div>
    </div>

    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" action="{{ route('admin.users.orders', [ 'id' => request()->id ] ) }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <!-- <div class="col-lg-3">
            <label>{{ __('item.name') }}</label>
            <input type="text" class="form-control">
          </div> -->
          <div class="col-lg-3">
                  <label class="">{{ __('category.name') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_2" name="category_id">
                    {{--<option {{ old('category_id') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>--}}
                    @foreach ( $categories as $category )
                      <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth ?? 0)}}</option>
                    @endforeach
                  </select>
                  @if ($errors->has('category_id'))
                      <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                  @endif
          </div>

          <div class="col-lg-3">
            <label>{{ __('words.order_status') }}</label>
                <select class="form-control kt-select2 {{ $errors->has('status') ? ' is-invalid' : '' }}" id="kt_select2_3" name="status">
                  <option {{ old('status') == 0 ? 'selected' : '' }} value="0"> {{ __('words.all')}}</option>
                  @foreach ( $orderStatus as $key => $orderSt )
                    <option {{ old('status') == $key ? 'selected' : '' }} value="{{ $key }}"> {{ $orderSt }}</option>
                  @endforeach
                </select>
                @if ($errors->has('status'))
                    <span class="invalid-feedback">{{ $errors->first('status') }}</span>
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
            <th>{{ __('user.user') }}</th>
            <th>{{ __('user.client') }}</th>
            <th>{{ __('user.accept') }}</th>
            <th>{{ __('order.total_first') }}</th>
            <th>{{ __('order.total') }}</th>
            <th>{{ __('words.order_status') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>
              <a href="{{ route('admin.orders.show' , [ 'id' => $item->id ] ) }}" class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right">
                {{ $item->id }}
              </a>
            </td>
            <td>{{ optional($item->user)->name }}{{ optional($item->user)->phone }}</td>
            <td>{{ optional($item->shop)->name }}{{ optional($item->shop)->phone }}</td>
            <td>{{ optional($item->accept)->name }}{{ optional($item->accept)->phone }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->total_first }}</td>
            <td>{{ $item->statusTitle }}</td>
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
