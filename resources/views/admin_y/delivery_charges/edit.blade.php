@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <x-buttons.but_back link="{{ route('admin.deliverycharges.index') }}"/>
               
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">

            <x-admin.nested.delivery-charge-row-edit :data="$data" :categories="$categories"/>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@section('js_pagelevel')
<!-- <x-admin.dropify-js/> -->
@endsection

@endsection
