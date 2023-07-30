@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css/>
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!-- search -->

  <div class="kt-portlet">


    <form class="kt-form kt-form--label-right" action="{{ route('admin.comments.index') }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <div class="col-lg-3">
            <label>{{ __('comment.name') }}</label>
            <input type="text" name="crit" value="{{ old('crit') }}" class="form-control">
          </div>
          <div class="col-lg-2">
            <label>{{ __('words.active') }}</label>
            <x-active-status/>
          </div>

          <div class="col-lg-1">
            <label>.</label>
            <div class="input-group"><x-buttons.but_agree/></div>
          </div>
          </form>

          <div class="col-lg-1">
            <label>.</label>
            <div class="input-group"><x-buttons.but_delete link='aaaa'/></div>
          </div>

        </div>
      </div>



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
            <th>{{ __('item.name') }}</th>
            <th>{{ __('comment.name') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.active') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $items)
            @foreach ($items as $item)
            <tr id="{{ $item->table_id }}">
              <td>{{ $item->table_id }}</td>
              <td>{{ optional($item->item->translation->first())->title }}</td>
              <td>
                <form action="{{ route('admin.comments.update_comment',['id' => $item->id ]) }}" onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');"  enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" id="_method" name="_method" value="PUT">
                  <textarea class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" max="200" name="comment" placeholder="" rows="4">{{ $item->comment }}</textarea>
                  <button class="btn btn-success" onclick="submitForm(this);"><i class="la la-check"></i>{{ __('words.update') }}</button>
                </form>
              </td>
              <td>{{ optional($item->user)->name }}</td>
              <td>{{ $item->created_at }}</td>
              <td>
                <form action="{{ route('admin.comments.status',['id' => $item->id ]) }}" onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');"  enctype="multipart/form-data" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" id="_method" name="_method" value="PUT">
                    <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                      <label>
                        <input type="checkbox"  {{ $item->approved ? 'checked' : '' }}  onclick="submitForm(this);">
                        <span></span>
                      </label>
                    </span>
                </form>
              </td>
            </tr>
            @endforeach
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
