@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css />
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!-- search -->

  <div class="kt-portlet">
   
  </div>



  <div class="kt-portlet kt-portlet--mobile">
  
    <div class="kt-portlet__body table-responsive">
      <style>
        .dataTables_wrapper div.dataTables_filter {
          display: contents;
        }
      </style>

      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
       

        <!-- free delegate -->
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ __('words.image') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('words.email') }}</th>
       
            <th>{{ __('words.chat') }}


          </tr>
        </thead>
        <tbody>
          @foreach ($users as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>
         
              <img src="{{ $item->imagePath() }}"
              style="max-height : 50px"
              class="  img-responsive img-thumbnail img-rounded">
            </td>
            <td>
              <a href="{{ route('admin.clients.edit' , [ 'id' => $item->id ] ) }}"
                class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                {{ $item->name }}<br>
              </a>
            </td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->email  }}</td>
    

            <td>
              <x-buttons.but_link link="{{ route('admin.messages.user' , [ 'id' => $item->id ] ) }}"
                  title="{{ __('words.preview') }}" />
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
<x-admin.datatable.footer-js />


@endsection