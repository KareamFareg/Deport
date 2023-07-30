@extends('admin.layouts.master')
@section('content')

<div class="col-xl-12 col-lg-12">

    <!--begin:: Widgets/Sale Reports-->
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    
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

                                    @foreach ($orders as $data)
                                    <?php $items = \App\Models\OrderItem::where('order_id' , $order->id);?>
                                    <tr>
                                        <td>
                                               <?php
                                                $username = \App\User::find($data->user_id)->name;
                                                echo $username;
                                               ?>

                                        <td>
                                        <td>
                                            <!-- @foreach($items as $item)
                                               $item->name; -->

                                        <td>
                                        <td>
                                               200 Ryal

                                        <td>
                                        <td>
                                            
                                            <div class="modal-footer">                                   
                                                <a href="{{ route('admin.meat.recieve' , ['id' => $data->id ]) }}" class=" btn btn-success " type="submit">
                                                    <i class="fa fa-pincel"></i>تم التوصيل
                                                </a>
                                                <a href="{{ route('admin.meat.delete' , ['id' => $data->id ]) }}" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}
                                                </a>
                                            </div>
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

@endsection
@section('js_pagelevel')
<x-admin.datatable.footer-js />

<script>
  function submitForm(me)
{
  $(me).closest("form").submit();
}
</script>

@endsection