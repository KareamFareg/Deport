@extends('admin.layouts.master')

@section('css_pagelevel')
<x-admin.datatable.header-css />
@endsection


@section('content')


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <!-- search -->

  <div class="kt-portlet">

  </div>



  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
      <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
          <div class="row">
            @if($type == 2 || $type == 3  || $type == 4)
            <button style="margin: 10px" type="button" class="btn btn-outline-success" data-toggle="modal"
              data-target="#Add">{{trans('notification.notification')}}</button>

            <!--begin:: Edit Modal-->
            <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <!-- form -->
                @php $notifyRouteName="admin.$typeName.notify" @endphp
                <form class="kt_form_1" enctype="multipart/form-data" action="{{ route($notifyRouteName) }}"
                  method="post">
                  {{ csrf_field() }}
                  <div class="modal-content">

                    <div class="modal-body">
                      <input type="hidden" name="group" value="{{$typeName}}">
                      <div class=" form-group">
                       <input type="text" name="title" class="form-control" placeholder="@lang('words.title')" id="">

                      </div>
                      <div class=" form-group">
                        <textarea name="message" placeholder="{{ __('notification.notification') }}"
                          class="form-control" rows="5"></textarea>

                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                          data-dismiss="modal">{{__('words.cancel')}}</button>
                        <button class=" btn btn-success " type="submit">
                          <i class="fa fa-plus"></i>{{__('words.send')}}
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!--end::Modal-->

            @endif
          </div>
        </h3>
      </div>

    </div>
    <div class="kt-portlet__body table-responsive">
      <style>
        .dataTables_wrapper div.dataTables_filter {
          display: contents;
        }
      </style>

      <!--begin: Datatable -->
      <table class="table table-striped- table-bordered table-hover table-checkable " id="kt_table_1">
        @if ($type == 1)
        <!-- admin -->
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ __('words.image') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('role.title') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('words.email') }}</th>
            <th>{{ __('words.active') }}</th>
            <th>{{ __('words.delete') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>
              <a class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                <img src="{{ $item->imagePath() }}">&nbsp;
              </a>
            </td>
            <td>
              @if(Auth::user()->id == $item->id || $item->read_only==0 )
              <a href="{{ route('admin.admins.edit' , [ 'id' => $item->id ] ) }}"
                class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                {{ $item->name }}
              </a>
              @else
              {{ $item->name }}
              @endif
            </td>
            <td>{{ $item->roles->first()->title }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->email }}</td>
            <td>
              @if(Auth::user()->id != $item->id || $item->read_only==0 )
              <form action="{{ route('admin.admins.status',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->is_active ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
              @endif
            </td>
            <td>
              @if(Auth::user()->id != $item->id || $item->read_only==0)

              @php $deleteRouteName="admin.$typeName.delete" @endphp
              <x-buttons.but_delete_one link="{{ route($deleteRouteName , [ 'id' => $item->id ] ) }}" />
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        @endif


        @if ($type == 2 )
        <!-- free delegate -->
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ __('words.image') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('user.gender') }}</th>
            <th>{{ __('user.amount') }}</th>

            <th>{{__('order.status_1')}}</th>
            <th>{{__('order.status_2')}}</th>
            <th>{{__('order.status_3')}}</th>
            <th>{{__('order.status_4')}}</th>
            <th>{{__('order.status_5')}}</th>
            <th>{{ __('words.rate') }}</th>
            {{-- <th>{{ __('words.chat') }} --}}

            {{--<th>{{ __('words.items') }}</th>--}}
            <th>{{ __('words.active') }}</th>
            <th>{{ __('words.delete') }}</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>
              <span class="tooltips" data-toggle="modal" data-target="#userImage-{{$item->id}}" style="cursor: pointer">
                <img src="{{   $item->image ? $item->imagePath() : $emptyImage }}" style="max-height : 100px" class="  img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal  fade" id="userImage-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{  $item->image ? $item->imagePath() : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <a href="{{ route('admin.clients.edit' , [ 'id' => $item->id ] ) }}"
                class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                {{ $item->name ? $item->name : $item->phone }}<br>
              </a>
            </td>
            <td>{{ $item->phone }}</td>
            <td>{{ ($item->gender == 'male') ?  __('user.male') :   __('user.female') }}</td>
            <td>{{  $item->amount}}</td>

            <td>{{\App\Models\Order::where(['user_id'=>$item->id,'status'=>1])->count()}}</td>
            <td>{{\App\Models\Order::where(['user_id'=>$item->id,'status'=>2])->count()}}</td>
            <td>{{\App\Models\Order::where(['user_id'=>$item->id,'status'=>3])->count()}}</td>
            <td>{{\App\Models\Order::where(['user_id'=>$item->id,'status'=>4])->count()}}</td>
            <td>{{\App\Models\Order::where(['user_id'=>$item->id,'status'=>5])->count()}}</td>
            <td>{{$item->rate}}</td>

            {{-- <td>
              <x-buttons.but_link link="{{ route('admin.chat.users' , [ 'id' => $item->id ] ) }}"
            title="{{ __('words.preview') }}" />
            </td> --}}

            {{--<td><x-buttons.but_link link="{{ route('admin.users.orders', [ 'id' => $item->id ] ) }}"
            title="{{ __('order.title') }}"/></td>--}}
            <td>
              <form action="{{ route('admin.clients.status',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->is_active ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
            </td>
            <td>
              @php $deleteRouteName="admin.$typeName.delete" @endphp
              <x-buttons.but_delete_one link="{{ route($deleteRouteName , [ 'id' => $item->id ] ) }}" />
            </td>
          </tr>
          @endforeach
        </tbody>
        @endif

        @if ($type == 3 )
        <!-- free delegate -->
        <thead>
          <tr>
            <th>ID</th>
            <th style="width: 10%">{{ __('words.image') }}</th>
            <th style="width: 10%">{{ __('user.id_card') }}</th>
            <th style="width: 10%">{{ __('user.license') }}</th>
            <th style="width: 10%">{{ __('user.carType') }}</th>
            <th style="width: 10%">{{ __('user.carNum') }}</th>
            <th style="width: 10%">{{ __('user.carSequenceNum') }}</th>
            <th style="width: 10%">{{ __('user.dateOfBirth') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('user.gender') }}</th>

            <th>{{__('order.status_2')}}</th>
            <th>{{__('order.status_3')}}</th>
            <th>{{__('order.status_4')}}</th>
            <th>{{__('order.status_5')}}</th>
            <th>{{ __('commission.paid_commissions') }}</th>
            <th>{{ __('commission.not_paid_commissions') }}</th>
            <th>{{ __('commission.deserved_amount') }}</th>
            <th>{{ __('words.rate') }}</th>
            <th>حاله المستخدم مع توصيل</th>
            {{--<th>{{ __('words.items') }}</th>--}}
            <th>{{ __('words.active') }}</th>
            <th>{{ __('words.approved') }}</th>
            <th>{{ __('words.delete') }}</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>

            <td>
              <span class="tooltips" data-toggle="modal" data-target="#userImage-{{$item->id}}"
                style="  cursor: pointer">
                <img src="{{   $item->image ? $item->imagePath() : $emptyImage  }}" style="width : 100px"
                  class="  img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal  fade" id="userImage-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">

                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $item->image ? $item->imagePath() : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <span class="tooltips" data-toggle="modal" data-target="#id_card-{{$item->id}}"
                style="  cursor: pointer">
                <img src="{{   $item->id_card ? asset('storage/app/'.$item->id_card)  : $emptyImage   }}" style="max-height : 100px"
                  class="  img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal  fade" id="id_card-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">

                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{  $item->id_card ? asset('storage/app/'.$item->id_card)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <span class="tooltips" data-toggle="modal" data-target="#license-{{$item->id}}" style="cursor: pointer">
                <img src="{{ $item->license ? asset('storage/app/'.$item->license)  : $emptyImage }}" style="max-height : 100px" class="img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal fade" id="license-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $item->license ? asset('storage/app/'.$item->license)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            @if($item->carTypeId !== null)
                <td>{{__('user.'.$item->carTypeId)}}</td>
            @else
            <td>لا يوجد</td>
            @endif
            @if($item->carNumber !== null)
            <td>{{$item->carNumber}}</td>
            @else
            <td>لا يوجد</td>
            @endif
            @if($item->vehicleSequenceNumber !== null)
            <td>{{$item->vehicleSequenceNumber}}</td>
            @else
            <td>لا يوجد</td>
            @endif
            @if($item->dateOfBirth !== null)
            <td>{{$item->dateOfBirth}}</td>
            @else
            <td>لا يوجد</td>
            @endif
            <td>
              <a href="{{ route('admin.shippers.edit', [ 'id' => $item->id ] ) }}"
                class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                {{ $item->name ? $item->name : $item->phone }}<br>
              </a>
            </td>
            <td>{{ $item->phone }}</td>
            <td>{{ ($item->gender == 'male') ?  __('user.male') :   __('user.female') }}</td>

            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>2])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>3])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>5])->count()}}</td>

            <td style="color: green ; font-weight: bold;">{{ $item->commission(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 1) }}
            </td>
            <td style="color: green ; font-weight: bold;" >{{ $item->commission(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 0) }}
            </td>
            <td style="color: red ; font-weight: bold;">
              {{ $item->deserved_amount(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 0) }}
            </td>

            <td>{{$item->rate}}</td>
            @if($item->refrenceCode)
            <td>{{$item->refrenceCode}}</td>
            @elseif($item->TawseelErrorMessage)
            <?php 
                 $Tawseelmessage =  \App\Traits\GeneralTrait::getErrorCode($item->TawseelErrorMessage);
              
            ?>
            <td>{{$Tawseelmessage}}</td>
            @else
            <td>لم يتم تقديم طلب التسجيل</td>
            @endif

            {{--<td><x-buttons.but_link link="{{ route('admin.users.orders', [ 'id' => $item->id ] ) }}"
            title="{{ __('order.title') }}"/></td>--}}
            <td>
              <form action="{{ route('admin.shippers.status',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->is_active ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
            </td>
            <td>
              <form action="{{ route('admin.shippers.approved',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->approved ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
            </td>
            <td>
              @php $deleteRouteName="admin.$typeName.delete" @endphp
              <x-buttons.but_delete_one link="{{ route($deleteRouteName , [ 'id' => $item->id ] ) }}" />
            </td>
          </tr>
          @endforeach
        </tbody>
        @endif


        @if ($type == 4 )
        <!-- free delegate -->
        <thead>
          <tr>
            <th>ID</th>
            <th style="width: 10%">{{ __('words.image') }}</th>
            <th style="width: 10%">{{ __('user.id_card') }}</th>
            <th style="width: 10%">{{ __('user.license') }}</th>
            <th>{{ __('user.name') }}</th>
            <th>{{ __('words.mobile') }}</th>
            <th>{{ __('user.gender') }}</th>

            <th>{{__('order.status_2')}}</th>
            <th>{{__('order.status_3')}}</th>
            <th>{{__('order.status_4')}}</th>
            <th>{{__('order.status_5')}}</th>
            <th>{{ __('commission.paid_commissions') }}</th>
            <th>{{ __('commission.not_paid_commissions') }}</th>
            <th>{{ __('commission.deserved_amount') }}</th>
            <th>{{ __('words.rate') }}</th>

            {{--<th>{{ __('words.items') }}</th>--}}
            <th>{{ __('words.active') }}</th>
            <th>{{ __('words.approved') }}</th>
            <th>{{ __('words.delete') }}</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr id="{{ $item->id }}">
            <td>{{ $item->id }}</td>

            <td>
              <span class="tooltips" data-toggle="modal" data-target="#userImage-{{$item->id}}"
                style="  cursor: pointer">
                <img src="{{   $item->image ? $item->imagePath() : $emptyImage  }}" style="width : 100px"
                  class="  img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal  fade" id="userImage-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">

                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $item->image ? $item->imagePath() : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <span class="tooltips" data-toggle="modal" data-target="#id_card-{{$item->id}}"
                style="  cursor: pointer">
                <img src="{{   $item->id_card ? asset('storage/app/'.$item->id_card)  : $emptyImage   }}" style="max-height : 100px"
                  class="  img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal  fade" id="id_card-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">

                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{  $item->id_card ? asset('storage/app/'.$item->id_card)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <span class="tooltips" data-toggle="modal" data-target="#license-{{$item->id}}" style="cursor: pointer">
                <img src="{{ $item->license ? asset('storage/app/'.$item->license)  : $emptyImage }}" style="max-height : 100px" class="img-responsive img-thumbnail img-rounded">
              </span>
              <div class="modal fade" id="license-{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $item->license ? asset('storage/app/'.$item->license)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <a href="{{ route("admin.shippers.edit" , [ 'id' => $item->id ] ) }}"
                class="kt-userpic kt-userpic--circle kt-margin-r-5 kt-margin-t-5" data-toggle="kt-tooltip"
                data-placement="right">
                {{ $item->name ? $item->name : $item->phone }}<br>
              </a>
            </td>
            <td>{{ $item->phone }}</td>
            <td>{{ ($item->gender == 'male') ?  __('user.male') :   __('user.female') }}</td>

            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>2])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>3])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->count()}}</td>
            <td>{{\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>5])->count()}}</td>

            <td style="color: green ; font-weight: bold;">{{ $item->commission(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 1) }}
            </td>
            <td style="color: green ; font-weight: bold;" >{{ $item->commission(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 0) }}
            </td>
            <td style="color: red ; font-weight: bold;">
              {{ $item->deserved_amount(\App\Models\Order::where(['shipper_id'=>$item->id,'status'=>4])->pluck('id'), 0) }}
            </td>

            <td>{{$item->rate}}</td>


            {{--<td><x-buttons.but_link link="{{ route('admin.users.orders', [ 'id' => $item->id ] ) }}"
            title="{{ __('order.title') }}"/></td>--}}
            <td>
              <form action="{{ route('admin.shippers.status',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->is_active ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
            </td>
            <td>
              <form action="{{ route('admin.shippers.approved',['id' => $item->id ]) }}"
                onsubmit="ajaxForm(event,this,'dt_dv','er_dv','');" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="_method" name="_method" value="PUT">
                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                  <label>
                    <input type="checkbox" {{ $item->approved ? 'checked' : '' }} onclick="submitForm(this);">
                    <span></span>
                  </label>
                </span>
              </form>
            </td>
            <td>
              @php $deleteRouteName="admin.$typeName.delete" @endphp
              <x-buttons.but_delete_one link="{{ route($deleteRouteName , [ 'id' => $item->id ] ) }}" />
            </td>
          </tr>
          @endforeach
        </tbody>
        @endif


      </table>



      <!--end: Datatable -->
    </div>
  </div>
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
