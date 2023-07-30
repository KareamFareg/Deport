@extends('admin.layouts.master')

@section('css_pagelevel')
{{--<x-admin.datatable.header-css/>--}}
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

     


    <div id="dt">
      <x-admin.datatable.dt-items :data='$data'/>
    </div>

  </div>
</div>


@endsection




@section('js_pagelevel')
{{--<x-admin.datatable.footer-js/>--}}

<script>
function submitForm(me)
{
  $(me).closest("form").submit();
}
</script>

@endsection
