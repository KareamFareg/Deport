@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form class="kt_form_1" action="{{ route('admin.faqs.store') }}" method="post">
        {{ csrf_field() }}

        <input type="hidden" value="{{ $trans }}" name="language">

        <div class="form-group row">
          <div class=" col-lg-5 col-md-5 col-sm-12">
            <input type="text" class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}" maxlength="500"
              required name="question[{{ $trans }}]" value="{{ old('question') }}"
              placeholder="{{ __('faq.question')}}">
          </div>

          <div class=" col-lg-5 col-md-5 col-sm-12">
            <input type="text" class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}" maxlength="500"
              required name="answer[{{ $trans }}]" value="{{ old('answer') }}" placeholder="{{ __('faq.answer')}}">
          </div>
          <div class=" col-lg-2 col-md-2 col-sm-12">
            <x-buttons.but_submit />
          </div>
        </div>

      </form>
    </div>
  </div>

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">

            <x-admin.trans-bar :languages="$languages" route="{{ route('admin.faqs.index') }}" :trans="$trans" />
          </div>
        </h3>
      </div>

    </div>

    <div class="kt-portlet__body">
      <!--Begin::Tab Content-->
      <div class="tab-content">
        <!--begin::tab 1 content-->
        <div class="tab-pane active" id="kt_widget11_tab1_content">


          <!--begin: Datatable -->
          <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
              <tr>
                <th>{{ __('faq.question') }}</th>
                <th>{{ __('faq.answer') }}</th>
                <th style="width: 15%">{{ __('words.control') }}</th>


              </tr>
            </thead>
            <tbody>
              @foreach ($data as $item)
              <tr>
                <form class="kt_form_1" action="{{ route('admin.faqs.update', [ 'id' => $item->id ] ) }}" method="post">
                  <input name="_method" type="hidden" value="PUT">
                  {{ csrf_field() }}
                  <td>
                    <input type="hidden" value="{{ $trans }}" name="language">

                    <input type="text" class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}"
                      maxlength="500" required name="question[{{ $trans }}]" @isset( $item->question[$trans] )
                    value="{{ old('question', $item->question[$trans] ) }}"
                    @else
                    value="{{ old('question') }}"
                    @endisset
                    placeholder="{{__('faq.question')}}"></td>
                  <td><input type="text" class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}"
                      maxlength="500" required name="answer[{{ $trans }}]" @isset( $item->answer[$trans] )
                    value="{{ old('answer', $item->answer[$trans] ) }}"
                    @else
                    value="{{ old('answer') }}"
                    @endisset
                    placeholder="{{__('faq.answer')}}"></td>
                  <td>
                    <x-buttons.but_update />
                </form>
                <x-buttons.but_delete_one link="{{ route('admin.faqs.delete' , [ 'id' => $item->id ] ) }} " />

                </td>

              </tr>
              @endforeach
            </tbody>
          </table>

          {{-- @foreach($data as $item)

          <form class="kt_form_1" action="{{ route('admin.faqs.update', [ 'id' => $item->id ] ) }}" method="post">
          <input name="_method" type="hidden" value="PUT">
          {{ csrf_field() }}

          <input type="hidden" value="{{ $trans }}" name="language">

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('faq.question') }}</label>
            <div class=" col-lg-7 col-md-9 col-sm-12">
              <input type="text" class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}"
                maxlength="500" required name="question[{{ $trans }}]" @isset( $item->question[$trans] )
              value="{{ old('question', $item->question[$trans] ) }}"
              @else
              value="{{ old('question') }}"
              @endisset
              placeholder="">
              @if ($errors->has('question'))
              <span class="invalid-feedback">{{ $errors->first('question') }}</span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('faq.answer') }}</label>
            <div class=" col-lg-7 col-md-9 col-sm-12">
              <input type="text" class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }}" maxlength="500"
                required name="answer[{{ $trans }}]" @isset( $item->answer[$trans] )
              value="{{ old('answer', $item->answer[$trans] ) }}"
              @else
              value="{{ old('answer') }}"
              @endisset
              placeholder="">
              @if ($errors->has('answer'))
              <span class="invalid-feedback">{{ $errors->first('answer') }}</span>
              @endif
            </div>
          </div>

          <div class="form-groub row ">
            <div class=" col-lg-2 col-md-3 col-sm-6">
              <x-buttons.but_update />
            </div>

          </div>

          </form>
          <div class="form-groub row ">

            <div class=" col-lg-2 col-md-3 col-sm-6">
              <x-buttons.but_delete_one link="{{ route('admin.faqs.delete' , [ 'id' => $item->id ] ) }} "
                id="{{$item->id}}" />
            </div>
          </div>
          <hr>

          @endforeach --}}


        </div>

      </div>

      <!--End::Tab Content-->
    </div>



  </div>

  <!--end:: Widgets/Sale Reports-->
</div>


@section('js_pagelevel')
<x-admin.dropify-js />
@endsection

@endsection