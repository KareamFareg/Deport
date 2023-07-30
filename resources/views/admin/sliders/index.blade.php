@extends('admin.layouts.master')
@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
 
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <style>
      .dataTables_wrapper div.dataTables_filter { display: contents; }
      </style>

      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
        <thead>
          <tr>
            {{-- <th>{{ __('slider.group') }}</th> --}}
            <th>{{ __('slider.position') }}</th>
            <th>{{ __('slider.control') }}</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr >
            {{-- <td>{{ $item->name }}</td> --}}
            <td>{{ $item->position }}</td>
            <td>
                <a  class="btn btn-outline-success"
            href="{{ route('admin.sliders.edit' , [ 'id' => $item->id ] ) }}">{{__('words.edit')}}</a>
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

