@extends('admin.layouts.master')
@section('css_pagelevel')
<x-admin.datatable.header-css />

<style>
    .dataTables_wrapper div.dataTables_filter {
        display: contents;
    }
</style>

@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

        <div class="kt-portlet__body">
            <form class="kt_form_1 row" enctype="multipart/form-data"
                action="{{ route('admin.clients.charge_wallet') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{$user->id}}" id="">
                <div class=" form-group col-lg-3">
                    <label for="">{{__('words.note')}}</label>
                    <textarea required name="message" class="form-control" rows="3"></textarea>
                </div>
                <div class=" form-group col-lg-3">
                    <label for="">{{__('words.amount')}}</label>
                    <input required class="form-control" type="number" min="0" value="0" name="amount">
                </div>


                <div class="form-group col-lg-1">
                    <label for="">&nbsp;</label>
                    <button class="form-control btn btn-success " type="submit">
                        <i class=" flaticon flaticon2-plus"></i>{{__('words.add')}}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
           @lang('words.wallet_transactions')
            </div>
        </div>

        <div class="kt-portlet__body">
            <style>
                .dataTables_wrapper div.dataTables_filter {
                    display: contents;
                }
            </style>

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('words.title')</th>
                        <th>@lang('words.description')</th>
                        <th>@lang('words.amount')</th>
                        <th>@lang('words.date')</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach($wallet_transactions as $transaction)
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>{{__('messages.' . $transaction->title)}}</td>
                        <td>{{__('messages.' . $transaction->description, ['amount' => $transaction->amount, 'order' => $transaction->order_code,'user_name'=>$transaction->user_name,'message'=>$transaction->message])}}
                        </td>
                        <td>{{$transaction->amount}}</td>
                        <td>{{$transaction->created_at->format('Y-m-d | H:i a')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
           @lang('words.online_transactions')
            </div>
        </div>

        <div class="kt-portlet__body">
            <style>
                .dataTables_wrapper div.dataTables_filter {
                    display: contents;
                }
            </style>

            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('words.title')</th>
                        <th>@lang('words.description')</th>
                        <th>@lang('words.amount')</th>
                        <th>@lang('words.date')</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach($online_transactions as $transaction)
                    <tr>
                        <td>{{$transaction->id}}</td>
                        <td>{{__('messages.' . $transaction->title)}}</td>
                        <td>{{__('messages.' . $transaction->description, ['amount' => $transaction->amount, 'order' => $transaction->order_code,'user_name'=>$transaction->user_name,'message'=>$transaction->message])}}
                        </td>
                        <td>{{$transaction->amount}}</td>
                        <td>{{$transaction->created_at->format('Y-m-d | H:i a')}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
</div>


@endsection


@section('js_pagelevel')
<x-admin.datatable.footer-js />



@endsection