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
    <form class="kt-form kt-form--label-right" action="{{ route('admin.items.index_coupons') }}" method="post">
          {{ csrf_field() }}

      <div class="kt-portlet__body">
        <div class="form-group row">

          <!-- <div class="col-lg-3">
            <label>{{ __('item.name') }}</label>
            <input type="text" class="form-control">
          </div> -->
          {{--
          <div class="col-lg-3">
                  <label class="">{{ __('category.name') }}</label>
                  <select class="form-control kt-select2 {{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="kt_select2_2" name="category_id">
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
          <tr id="{{ $item->item_id }}">
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
