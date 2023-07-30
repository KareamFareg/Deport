<style>
      
      h1{
        font-size: 30px;
        color: #fff;
        text-transform: uppercase;
        font-weight: 300;
        text-align: center;
        margin-bottom: 15px;
      }
      table{
        width:100%;
        table-layout: fixed;
      }
      .tbl-header{
        background-color: #25b7c4;
        font-weight:bold;
       }
      .tbl-content{
        height:30px;
        /*overflow-x:auto;*/
        margin-top: 0px;
        /*border: 1px solid rgba(255,255,255,0.3);*/
      }
      th{
        padding: 20px 15px;
        text-align: left;
        font-weight: 500;
        font-size: 12px;
        color:#000;
        text-transform: uppercase;
      }
      td{
        padding: 15px;
        text-align: left;
        vertical-align:middle;
        font-weight: 300;
        font-size: 12px;
        color: #000;
        border-bottom: solid 1px rgba(255,255,255,0.1);
      }
      
      
      /* demo styles */
      
      @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
      /*body{*/
      /*  background: -webkit-linear-gradient(left, #25c481, #25b7c4);*/
      /*  background: linear-gradient(to right, #25c481, #25b7c4);*/
      /*  font-family: 'Roboto', sans-serif;*/
      /*}*/
      section{
        margin: 50px;
      }
      
      
      /* follow me template */
      .made-with-love {
        margin-top: 40px;
        padding: 10px;
        clear: left;
        text-align: center;
        font-size: 10px;
        font-family: arial;
        color: #fff;
      }
      .made-with-love i {
        font-style: normal;
        color: #F50057;
        font-size: 14px;
        position: relative;
        top: 2px;
      }
      .made-with-love a {
        color: #fff;
        text-decoration: none;
      }
      .made-with-love a:hover {
        text-decoration: underline;
      }
      
      
      /* for custom scrollbar for webkit browser*/
      
      /*::-webkit-scrollbar {*/
      /*    width: 6px;*/
      /*} */
      /*::-webkit-scrollbar-track {*/
      /*    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); */
      /*} */
      /*::-webkit-scrollbar-thumb {*/
      /*    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); */
      /*}*/
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
                                        <td>
                                            <x-buttons.but_edit
                                                link="{{ route('markets.getAll', ['id' => $data->id]) }}" />
                                        </td>
                                        
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