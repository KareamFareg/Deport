
        <style>
            .dataTables_wrapper div.dataTables_filter {
                display: contents;
            }

            .dataTables_wrapper div.dataTables_filter {
                margin-left: 822px;
                display: none;
            }

            .dataTables_wrapper div.dataTables_paginate {
                display: none;
            }

            .dataTables_wrapper div.dataTables_info {
                display: none;
            }

        </style>


        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('notification.sender') }}</th>
                    <th>{{ __('notification.reciever') }}</th>
                    <th>{{ __('notification.notification') }}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr id="{{ $notification->id }}">
                        <td>{{ $notification->id }}</td>
                        <td>{{ $notification->user_sender()->first()->name }}</td>
                        <td>{{ $notification->user_reciever()->first()->name }}</td>
                        <td>{{ $notification->data }}</td>

                    </tr>
                @endforeach
            </tbody>


        </table>
        {{ $notifications->links() }}


@include('components.admin.datatable.datatable_init')
