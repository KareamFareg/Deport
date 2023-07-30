@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            <div class="row">
              <x-buttons.but_new link="{{ route('admin.categories.create') }}"/>
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.categories.index') }}" :trans="$trans"/>
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
                    <td style="width:50%"></td>
                    <td style="width:20%"></td>
                    <td style="width:15%"></td>
                    <td style="width:15%"></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($categories as $category)
                    <x-admin.nested.category-row :data="$category"/>
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
