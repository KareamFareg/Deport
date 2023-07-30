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

  </div>






  <div class="kt-portlet kt-portlet--mobile">

     

    <div class="kt-portlet__body">
      <style>
      .dataTables_wrapper div.dataTables_filter { display: contents; }
      </style>

      <!--begin: Datatable -->
      <table class="table-responsive table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
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
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->mobile }}</td>
            <td>{{ $item->type->title }}</td>
            <td>
              <a class="btn btn-bold btn-label-brand btn-sm" data-href="{{ route('admin.contacts.details' , [ 'id' => $item->id ] ) }}" onclick="ajaxlink(event,this,'contact_us_details','err_contact_us_details','');" data-toggle="modal" data-target="#modal_contact_us_details">{{ __('words.details') }}</a>
            </td>
            <td>{{ optional($item->user)->name }} - {{ optional($item->user)->phone }}</td>
            <td>{{ $item->created_at }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div class="modal fade" id="modal_contact_us_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
<x-admin.datatable.footer-js/>
<script>
function submitForm(me)
{
  $(me).closest("form").submit();
}
</script>
@endsection
