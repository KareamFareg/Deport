@extends('admin.layouts.master')
@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <div class="row">
                        <button style="margin: 10px" type="button" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#Add">{{trans('words.add')}}</button>
                        <!--begin:: Edit Modal-->
                        <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!-- form -->
                                <form class="kt_form_1" enctype="multipart/form-data"
                                    action="{{ route('admin.bank_account.create') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                placeholder="{{ __('bank_account.user_name') }}" name="user_name">
                                            </div>
                                             <div class=" form-group">
                                                <input class="form-control" type="text" required
                                                placeholder="{{ __('bank_account.bank_name') }}" name="bank_name">
                                            </div>
                                            <div class=" form-group">
                                                <input class="form-control" type="number" required
                                                placeholder="{{ __('bank_account.account_number') }}" name="account_number">
                                            </div>


                                            <div class=" form-group">
                                                <input class="form-control" type="number" required
                                                placeholder="{{ __('bank_account.national_account_number') }}"
                                                name="national_account_number">


                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.add')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Modal-->

                      
                    </div>
                </h3>
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
                        <th>{{ __('bank_account.user_name') }}</th>
                        <th>{{ __('bank_account.bank_name') }}</th>
                        <th>{{ __('bank_account.account_number') }}</th>
                        <th>{{ __('bank_account.national_account_number') }}</th>
                        <th>{{ __('words.control') }}</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user_name }}</td>
                        <td>{{ $item->bank_name }}</td>
                        <td>{{ $item->account_number }}</td>
                        <td>{{ $item->national_account_number }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                data-target="#EditModal-{{ $item->id }}">{{trans('words.edit')}}</button>
                            <!--begin:: Edit Modal-->
                            <div class="modal fade" id="EditModal-{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!-- form -->
                                    <form class="kt_form_1" enctype="multipart/form-data"
                                        action="{{ route('admin.bank_account.update', ['id' => $item->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$item->bank_name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class=" form-group">
                                                    <input class="form-control "  required type="text" placeholder="{{ __('bank_account.user_name') }}" value="{{ $item->user_name }}" name="user_name">
                                                </div>
                                                <div class=" form-group">
                                                    <input class="form-control "  required type="text" placeholder="{{ __('bank_account.bank_name') }}" value="{{  $item->bank_name }}" name="bank_name">
                                                </div>
                                                <div class=" form-group">
                                                    <input class="form-control "  required type="number" placeholder="{{ __('bank_account.account_number') }}" value="{{  $item->account_number }}" name="account_number">
                                                </div>
                                                <div class=" form-group">
                                                    <input class="form-control "  required type="number" placeholder="{{ __('bank_account.national_account_number') }}" value="{{  $item->national_account_number }}" name="national_account_number">
                                                </div>
                                                
                                                
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{__('words.cancel')}}</button>
                                                <button class=" btn btn-success " type="submit">
                                                    <i class="fa fa-plus"></i>{{__('words.edit')}}
                                                </button>
                                            </div>
                                        </div>
                                </div>
                                </form>
                            </div>
                            <!--end::Modal-->
                            <x-buttons.but_delete_one link="{{route('admin.bank_account.delete',['id'=>$item->id])}}" />

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