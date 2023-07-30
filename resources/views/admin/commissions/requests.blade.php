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
            <form class="kt_form_1 row" enctype="multipart/form-data" action="{{ route('admin.commission.requests') }}"
                method="post">
                {{ csrf_field() }}
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.shipper')}}</label>
                    <select class="form-control kt-select2 " id="kt_select2_3" name="shipper">
                        <option value="0"> {{ __('commission.all_shippers') }}</option>
                        @foreach ( \App\User::Info()->where('type_id',3)->get() as $user)
                        <option @if($user->id ==$shipper) selected @endif value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.from')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" value="{{$from ?? ''}}" name="from">
                </div>
                <div class=" form-group col-lg-3">
                    <label for="">{{__('commission.to')}}</label>
                    <input class="form-control datepicker"  placeholder="yyyy-mm-dd"  autocomplete="off" value="{{$to ?? ''}}" name="to">
                </div>
                <div class="form-group col-lg-1">
                    <label for="">&nbsp;</label>
                    <button class="form-control btn btn-success " type="submit">
                        <i class=" flaticon flaticon2-search-1"></i>{{__('words.search')}}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">

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
                        <th>{{ __('commission.shipper') }}</th>
                        <th>{{ __('commission.name') }}</th>
                        <th>{{ __('bank_account.bank_name') }}</th>
                        <th>{{ __('commission.amount') }}</th>
                        <th>{{ __('commission.date') }}</th>
                        <th>{{ __('commission.note') }}</th>
                        <th>{{ __('commission.image') }}</th>
                        <th>{{ __('words.control') }}</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach ($commissions as $commission)
                    <tr>
                        <td>{{ $commission->id }}</td>
                        <td>{{  optional(\App\User::find($commission->user_id))->name }}</td>
                        <td>{{ $commission->anme }}</td>
                        <td>{{ $commission->bank_name }}</td>
                        <td>{{ $commission->amount }} ريال  </td>
                        <td>{{ $commission->date }}</td>
                        <td>{{ $commission->note }}</td>
                        <td>
                           

                        <span class="tooltips" data-toggle="modal" data-target="#commission{{$commission->id}}"
                                style="  cursor: pointer">

                                <img src="{{ $commission->image ? asset('storage/app/' . $commission->image) : $emptyImage }}" style="max-height : 100px"
                                    class="  img-responsive img-thumbnail img-rounded">
                            </span>

                            <div class="modal  fade" id="commission{{$commission->id}}" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered ">
                                    <div class="modal-content">

                                        <div class="modal-content">
                                            <div class="modal-body" style=" text-align: center;">
                                                <img style="width : 100% "
                                                    src="{{ $commission->image ? asset('storage/app/' . $commission->image) : $emptyImage }}"
                                                    class="  img-responsive ">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </td>
                        <td>
                            @if($commission->status ==0)
                            <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#AcceptModal-{{ $commission->id }}">{{trans('commission.accept')}}</button>
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                                data-target="#CanceltModal-{{ $commission->id }}">{{trans('commission.cancel')}}</button>
                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="AcceptModal-{{ $commission->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>{{__('commission.accept_message')}}</h4>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{__('words.cancel')}}</button>
                                            <a href="{{ route('admin.commission.accept',['id'=>$commission->id]) }}" class=" btn btn-success ">
                                                {{__('commission.accept')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Modal-->
                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="CanceltModal-{{ $commission->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>{{__('commission.cancel_message')}}</h4>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{__('words.cancel')}}</button>
                                            <a href="{{ route('admin.commission.cancel',['id'=>$commission->id]) }}" class=" btn btn-danger ">
                                                {{__('commission.cancel')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Modal-->
                            @else
                            @if($commission->status ==1)
                            <label class=" btn btn-success "> {{__('commission.accepted')}}</label>
                            @else
                            <label class=" btn btn-danger "> {{__('commission.canceled')}}</label>

                            @endif
                            @endif

                        </td>


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