@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.badwords.index') }}" :trans="$trans"/>
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



<!-- form -->
<!-- enctype="multipart/form-data" -->


        <div class="kt-portlet__body">
          <!--Begin::Tab Content-->
          <div class="tab-content">
            <!--begin::tab 1 content-->
            <div class="tab-pane active" id="kt_widget11_tab1_content">

              <form class="kt_form_1"  action="{{ route('admin.badwords.update', [ 'id' => $data->id ]) }}" method="post">
                  {{ csrf_field() }}

                  <input type="hidden" value="put" name="_method">
                  <input type="hidden" value="{{ $trans }}" name="language">

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('admin/dashboard.badwords') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                        <textarea class="form-control {{ $errors->has('words') ? ' is-invalid' : '' }}" name="words" placeholder="" required rows="6">{{ old('words' , $words ) }}</textarea>
                        @if ($errors->has('words'))
                                <span class="invalid-feedback">{{ $errors->first('words') }}</span>
                        @endif
                    </div>
                  </div>

                  <x-buttons.but_submit/>
              </form>

            </div>
          </div>
          <!--End::Tab Content-->
        </div>



  </div>

  <!--end:: Widgets/Sale Reports-->
</div>


@section('js_pagelevel')
  <x-admin.dropify-js/>
@endsection

@endsection
