<table class="table table-striped- table-bordered table-hover table-checkable" id="main_div">
    <tbody>
        <tr>
            <td>{{ __('order.user') }}</td>
            <td>

                <ul>
                    <li>
                        <a href="{{ route("admin.clients.edit" , [ 'id' => $data->user_id ] ) }}">
                            {{ optional($data->user_data)->name }}
                        </a>
                    </li>

                    @if(\App\Models\Rate::where(['user_id'=> $data->user_id ,'order_id'=>$data->id
                    ])->first())
                    <li>
                        {{ __('order.rate') }} :
                        @php
                        $rate=\App\Models\Rate::where(['user_id'=> $data->user_id ,'order_id'=>$data->id
                        ])->first();

                        for ($x = 1; $x <= $rate->rate; $x++) { echo ' <i style="color: gold" class="fa fa-star"></i> '
                            ; }

                            @endphp
                    </li>
                    <li> {{ __('order.order_comment') }} : {{$rate->comment}}</li>
                    @endif

                </ul>


            </td>

        </tr>

        @if($data->shipper_data)
        <tr>
            <td>{{ __('order.shipper') }}</td>
            <td>
                <ul>
                    <li> <a href="{{ route("admin.shippers.edit" , [ 'id' => optional($data->shipper_data)->id ] )  }}">
                            {{ optional($data->shipper_data)->name }}
                        </a>
                    </li>
                    @if(\App\Models\Rate::where(['user_id'=> $data->shipper_id ,'order_id'=>$data->id
                    ])->first())
                    <li>
                        {{ __('order.rate') }} :
                        @php
                        $rate=\App\Models\Rate::where(['user_id'=> $data->shipper_id ,'order_id'=>$data->id
                        ])->first();

                        for ($x = 1; $x <= $rate->rate; $x++) { echo ' <i style="color: gold" class="fa fa-star"></i> '
                            ; }

                            @endphp
                    </li>
                    <li> {{ __('order.order_comment') }} : {{$rate->comment}}</li>
                    @endif

                </ul>




            </td>
        </tr>
        @endif

    </tbody>
</table>