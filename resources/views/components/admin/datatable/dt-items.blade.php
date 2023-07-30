<x-admin.datatable.header-css/>

{{ $data->links()}}

<div class="kt-portlet__body">
  <style>
  .dataTables_wrapper div.dataTables_filter { display: contents; }
  </style>

  <!--begin: Datatable -->
  <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
    <thead>
      <tr>
        <th>ID</th>
        <th></th>
        <th>{{ __('user.name') }}</th>
        <th>{{ __('words.description') }}</th>
        <th>{{ __('words.links') }}</th>
        <th>{{ __('words.views_count') }}</th>
        <th>{{ __('words.likes_count') }}</th>
        <th>{{ __('words.comments_count') }}</th>
        <th>{{ __('words.date') }}</th>
        <th>{{ __('words.active') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $item)
      <tr id="{{ $item->id }}">
        <td>
          <a href="{{ route('admin.items.edit' , [ 'id' => $item->id ] ) }}" class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right">
            {{ $item->id }}
          </a>
        </td>
        <td>
          @if ($item->user)
          <a href="{{ route('admin.users.edit' , [ 'id' => $item->user->id ] ) }}" class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right">
            <img src="{{ $item->user->imagePath() }}">
          </a>
          @endif
        </td>
        <td>
          @if ($item->user)
            {{ $item->user->name }}
          @endif
        </td>
        <td>{{ optional($item->item_info->first())->description }}</td>
        <td>{{ $item->links }}</td>
        <td>{{ $item->views }}</td>
        <td>{{ $item->likes }}</td>
        <td>{{ $item->comments }}</td>
        <td>{{ $item->created_at }}</td>
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
      </tr>
      @endforeach
    </tbody>
  </table>

  <!--end: Datatable -->
</div>


<x-admin.datatable.footer-js/>

<script>
function submitForm(me)
{
  $(me).closest("form").submit();
}
</script>
