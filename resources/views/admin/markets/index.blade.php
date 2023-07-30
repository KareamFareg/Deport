@extends('admin.layouts.master')

</style>
<table>
    <thead>
        <tr class="tbl-header">
            <td>اسم السوق</td>
            <td>اسم الصوره</td>
        </tr>
    </thead>
    <tbody class="tbl-content">
        @foreach($markets as $market)
        <tr >
            <td>{{$market->name}}</td>
            <td>{{$market->icon}} </td>
        </tr>
        @endforeach
    </tbody>
</table>





@section('content')

<div class="col-xl-12 col-lg-12" >
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

                                    @foreach ($markets as $data)
                                    <tr>
                        
                                        <td>$data->name</td>
                                       
                                        
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
    function submitForm(me) {
            // $("#frm_category_status").submit();
            $(me).closest("form").submit();
        }

</script>
@endsection

@endsection