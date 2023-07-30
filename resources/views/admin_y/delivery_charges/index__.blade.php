@extends('admin.layouts.master')

@section('content')

<div class="col-xl-6 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
    {{--
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
              <x-buttons.but_new link="{{ route('admin.deliverycharges.create') }}"/>
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.deliverycharges.index') }}" :trans="$trans"/>
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
    --}}


    <!-- sticky head -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
      <div class="row">
        <div class="col-lg-12">
          <!--begin::Portlet-->
          <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">

              <!-- <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('words.search') }}
                  <small>try to scroll the page</small>
                </h3>
              </div> -->




              <form class="kt-form kt-form--label-right">
                <div class="kt-portlet__body">
                  <div class="form-group row">

                        <select class="form-control kt-select2 {{ $errors->has('parents') ? ' is-invalid' : '' }}" id="kt_select2_3" required name="category_id">
                          <option {{ old('category_id') == 0 ? 'selected' : '' }} value="0">{{ __('words.all') }}</option>
                          @foreach ( $categories as $category )
                            <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}"> {{ $category->title }} {{str_repeat('__', $category->depth)}}</option>
                          @endforeach
                        </select>
                        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                        @if ($errors->has('category_id'))
                            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                        @endif
                    <div class="col-lg-4">
                      <!-- <label class="">Email:</label>
                      <input type="email" class="form-control" placeholder="Enter email">
                      <span class="form-text text-muted">Please enter your email</span> -->
                    </div>
                    <div class="col-lg-4">
                      <!-- <label>Username:</label>
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
                        <input type="text" class="form-control" placeholder="">
                      </div>
                      <span class="form-text text-muted">Please enter your username</span> -->
                    </div>
                  </div>
                </div>
              </form>







            </div>
          </div>
          <!--end::Portlet-->
        </div>
      </div>
    </div>
    <!-- end sticky head -->


    <form class="kt-form kt-form--label-right">
      <div class="kt-portlet__body">
        <div class="form-group row">
          <x-admin.nested.delivery-charge-row-add :data="$category" :categories="$categories"/>
        </div>
      </div>
    </form>




    <div class="kt-portlet__body">

      <!--Begin::Tab Content-->
      <div class="tab-content">

        <!--begin::tab 1 content-->
        <div class="tab-pane active" id="kt_widget11_tab1_content">

          <!--begin::Widget 11-->
          <div class="kt-widget11">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <td style="width:35%">{{ __('delivery_charge.category') }}</td>
                    <td style="width:15%">{{ __('delivery_charge.from') }}</td>
                    <td style="width:15%">{{ __('delivery_charge.to') }}</td>
                    <td style="width:15%">{{ __('delivery_charge.charge') }}</td>
                    <td style="width:20%"></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($categories as $category)
                    <x-admin.nested.delivery-charge-row-edit :data="$category" :categories="$categories"/>
                  @endforeach

                </tbody>
              </table>
            </div>
            <!-- <div class="kt-widget11__action kt-align-right">
              <button type="button" class="btn btn-label-brand btn-bold btn-sm">Import Report</button>
            </div> -->
          </div>

          <!--end::Widget 11-->
        </div>

      </div>

      <!--End::Tab Content-->
    </div>
  </div>

  <!--end:: Widgets/Sale Reports-->
</div>


@section('js_pagelevel')
  <script>
  function submitForm(me)
  {
    // $("#frm_category_status").submit();
    $(me).closest("form").submit();
  }
  </script>
@endsection

@endsection
