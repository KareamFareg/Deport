@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.conditions.index') }}" :trans="$trans"/>
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

              @foreach($data as $item)
              <form class="kt_form_1"  action="{{ route('admin.conditions.update', [ 'id' => $item->id ] ) }}" method="post">
                  <input name="_method" type="hidden" value="PUT">
                  {{ csrf_field() }}

                  <input type="hidden" value="{{ $trans }}" name="language">

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ optional($item->category->category_info->first())->title }}</label>
                  </div>

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('condition_1') ? ' is-invalid' : '' }}"
                          maxlength="500" required name="condition_1[{{ $trans }}]"
                          @isset( $item->condition_1[$trans] )
                            value="{{ old('condition_1', $item->condition_1[$trans] ) }}"
                          @else
                            value="{{ old('condition_1') }}"
                          @endisset
                           placeholder="">
                          @if ($errors->has('condition_1'))
                                  <span class="invalid-feedback">{{ $errors->first('condition_1') }}</span>
                          @endif
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('condition_2') ? ' is-invalid' : '' }}"
                          maxlength="500" required name="condition_2[{{ $trans }}]"
                          @isset( $item->condition_2[$trans] )
                            value="{{ old('condition_2', $item->condition_2[$trans] ) }}"
                          @else
                            value="{{ old('condition_2') }}"
                          @endisset
                          placeholder="">
                          @if ($errors->has('condition_2'))
                                  <span class="invalid-feedback">{{ $errors->first('condition_2') }}</span>
                          @endif
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_conditions') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                          <input type="text" class="form-control {{ $errors->has('condition_3') ? ' is-invalid' : '' }}"
                          maxlength="500" required name="condition_3[{{ $trans }}]"
                          @isset( $item->condition_3[$trans] )
                            value="{{ old('condition_3', $item->condition_3[$trans] ) }}"
                          @else
                            value="{{ old('condition_3') }}"
                          @endisset
                           placeholder="">
                          @if ($errors->has('condition_3'))
                                  <span class="invalid-feedback">{{ $errors->first('condition_3') }}</span>
                          @endif
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{ __('setting.agree_contract') }}</label>
                    <div class=" col-lg-7 col-md-9 col-sm-12">
                      <input type="text" class="form-control {{ $errors->has('contract') ? ' is-invalid' : '' }}"
                      maxlength="1000" required name="contract[{{ $trans }}]"
                      @isset( $item->contract[$trans] )
                        value="{{ old('contract', $item->contract[$trans] ) }}"
                      @else
                        value="{{ old('contract') }}"
                      @endisset
                        placeholder="">
                      <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                      @if ($errors->has('contract'))
                            <span class="invalid-feedback">{{ $errors->first('contract') }}</span>
                      @endif
                    </div>
                  </div>

                  <x-buttons.but_submit/>

              </form>

              <hr>

              @endforeach


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
