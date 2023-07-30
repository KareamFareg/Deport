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

      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
        <thead>
          <tr>
            <th>{{ __('comment.name') }}</th>
            <th>{{ __('comment.sender') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.order') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->comment }}</td>
            <td>{{ optional($item->sender)->name }}</td>
            <td>{{ optional($item->user)->name }}</td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->order_id }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!--end: Datatable -->
    </div>
  </div>
</div>
