@extends('admin.layouts.master')

@section('content')

<div class="col-xl-12 col-lg-12">

  <!--begin:: Widgets/Sale Reports-->
  <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">

    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            <x-buttons.but_new link="{{ route('admin.countries.create') }}"/>
            <x-admin.trans-bar :languages="$languages" route="{{ route('admin.countries.index') }}" :trans="$trans"/>
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
                  </tr>
                </thead>
                <tbody>
                  @foreach($countries as $country)
                    <tr>
                      <td>
                        <a style="padding-right: {{$country->depth * 30}}px;padding-left: {{$country->depth * 20}}px; font-weight: {{ $country->depth == 0 ?  600 : '400' }};"
                          class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip" data-placement="right">
                          {{ $country->title ?? $country->title_general.' : '.'غير مترجم' }}
                        </a>
                      </td>
                      <td>
                        <form action="{{ route('admin.countries.status',['id' => $country->id ]) }}" method="post" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden" id="_method" name="_method" value="PUT">
                            <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                              <label>
                                <input type="checkbox"  {{ $country->is_active ? 'checked' : '' }}  onclick="submitForm(this);">
                                <span></span>
                              </label>
                            </span>
                        </form>
                      </td>
                      <td></td>
                    </tr>
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
