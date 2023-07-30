@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.adv_periods.index') }}" :trans="$trans"/>
            </div>
        </h3>
      </div>
      <!-- <div class="kt-portlet__head-toolbar">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#kt_widget11_tab1_content" role="tab">
              Last Month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#kt_widget11_tab2_content" role="tab">
              All Time
            </a>
          </li>
        </ul>
      </div> -->
    </div>





<div class="col-lg-12 col-md-12">
    <form class="form-inline" action="{{ route('admin.adv_periods.store') }}" method="POST" enctype="multipart/form-data" >
      <div class="form-row align-items-center">
        @csrf
        <div class="col-auto">
          <input type="text" id="title" name="title"  class="form-control" value="{{ old('title') }}">
          <input type="number" id="period" name="period"   class="form-control" value="{{ old('period') }}" required maxlength="3">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary mb-2">اضافة</button>
        </div>
      </div>
    </form>
    <br><br>
    @foreach ($data as $advPeriod)
      <form class="form-inline" action="{{ route('admin.adv_periods.update' ,['id' => $advPeriod->id]) }}" method="POST" enctype="multipart/form-data" >
        <div class="form-row align-items-center">
          @csrf
          <input type="hidden" name="_method" value="PUT">
          <div class="col-auto">
            <input type="text" id="title" name="title"   class="form-control" value="{{ $advPeriod->title }}" required maxlength="50">
            <input type="number" id="period" name="period"   class="form-control" value="{{ $advPeriod->period }}" required maxlength="3">
          </div>
          <div class="col-auto">
            <!-- <button type="submit" class="btn btn-primary mb-2">{{trans('word.Save')}}</button> -->
              <x-buttons.but_submit/>
          </div>
        </div>
      </form>
    <br>
    @endforeach
</div>


  </div>

  <!--end:: Widgets/Sale Reports-->
</div>


@section('js_pagelevel')
  <x-admin.dropify-js/>
@endsection

@endsection
