@extends('admin.layouts.master')

@section('css_pagelevel')
    <x-admin.datatable.header-css />
@endsection


@section('content')





    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body">


            <!--begin: Datatable -->
            <div class="table-response">
                <form method="post" action="{{ route('admin.notifications.index') }}" class="form-inline" id="frm_search"
                    style="border: 1px solid #e1e1e1;border-radius: 10px;padding: 15px;margin-bottom: 15px;">
                    <div class="form-group mb-2" style="text-align: center;margin: auto; margin-bottom: auto;">
                        @csrf
                        <span style="width :50px;"> بحث عام </span>
                        <input type="text" class="form-control input-sm" id="crit" name="crit" value="{{ old('crit') }}"
                            style="width:450px">
                        &nbsp;&nbsp;&nbsp;

                        <input type='submit' class="btn btn-primary" value="بحث" style="width:140px">
                    </div>
                </form>
                <div id="dt">


                    @include('admin.notifications.data', ['notifications' => $notifications])

                </div>
            </div>

            <!--end: Datatable -->
        </div>
    </div>


@endsection




@section('js_pagelevel')
    <x-admin.datatable.footer-js />

    <script>
        function submitForm(me) {
            $(me).closest("form").submit();
        }

    </script>

@endsection
