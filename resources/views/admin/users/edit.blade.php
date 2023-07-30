

@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              @php $backRouteName="admin.$typeName.index" @endphp
              <x-buttons.but_back link="{{ route($backRouteName) }}" />
              

              @if($type == 2)
              <x-buttons.but_link link="{{ route('admin.clients.wallet', [ 'id' => $user->id ] ) }}"
                title="{{ __('words.transactions') }}" />

              @endif

              @if($type != 1)

              @php $ordersRouteName="admin.$typeName.orders" @endphp
              <x-buttons.but_link link="{{ route($ordersRouteName, [ 'id' => $user->id ] ) }}"
                title="{{ __('order.title') }}" />

              @php $rateRouteName="admin.$typeName.rate" @endphp
              <x-buttons.but_link link="{{ route($rateRouteName, [ 'id' => $user->id ] ) }}"
                title="{{ __('words.rate') }}" />

               
            <button style="margin: 10px" type="button" class="btn btn-outline-success" data-toggle="modal"
              data-target="#Add">{{trans('notification.notification')}}</button>

            <!--begin:: Edit Modal-->
            <div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <!-- form -->
                @php $notifyRouteName="admin.$typeName.notifyUser" @endphp
                <form class="kt_form_1" enctype="multipart/form-data" action="{{ route($notifyRouteName,['id'=>$user->id ]) }}"
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


            </h3>
          </div>
        </div>


        <div class="kt-portlet__body ">
          <div class="kt-section kt-section--first">
            <!-- form -->
            <form class="kt_form_1" enctype="multipart/form-data"
              action="{{route("admin.$typeName.update", [ 'id' => $user->id ] )}}" method="post">
              {{ csrf_field() }}
              <input name="_method" type="hidden" value="PUT">

              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.name') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                    maxlength="150" value="{{ old('name', $user->name) }}" name="name"
                    placeholder="{{ __('user.name') }}">
                  @if ($errors->has('name'))
                  <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.email') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="email" type="email" autocomplete="off" placeholder="{{ __('words.email') }}"
                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    value="{{ old('email',$user->email) }}" maxlength="50" autocomplete="email">
                  @if ($errors->has('email'))
                  <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.password') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="password" type="password" placeholder="{{ __('words.password') }} "
                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    autocomplete="current-password" minlength="6" maxlength="12">
                  @if ($errors->has('password'))
                  <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm"
                  class="col-form-label col-lg-3 col-sm-12">{{ __('auth.confirm_password') }}</label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  <input id="password-confirm" type="password" placeholder="{{ __('auth.confirm_password') }}"
                    class="form-control" name="password_confirmation" minlength="6" maxlength="12"
                    autocomplete="new-password">
                </div>
              </div>


              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.phone') }}</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required
                    maxlength="10" name="phone" placeholder="{{ __('words.phone') }}"
                    value="{{ old('phone',$user->phone) }}">
                  @if ($errors->has('phone'))
                  <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                  @endif
                </div>
              </div>



              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.gender') }} </label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  <select class="form-control kt-select2 {{ $errors->has('gender') ? ' is-invalid' : '' }}"
                    id="kt_select2_3" name="gender">
                    <option {{ old('gender',$user->gender) == 'male' ? 'selected' : '' }} value="male">
                      {{__('user.male')}}</option>
                    <option {{ old('gender',$user->gender) == 'female' ? 'selected' : '' }} value="female">
                      {{__('user.female')}}</option>
                  </select>
                  @if ($errors->has('gender'))
                  <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                  @endif
                </div>
              </div>
              @if($type == 2)
              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.amount') }} </label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" required
                     name="amount" placeholder="{{ __('user.amount') }}"
                    value="{{ old('amount',$user->amount) }}">
                  @if ($errors->has('amount'))
                  <span class="invalid-feedback">{{ $errors->first('amount') }}</span>
                  @endif
                </div>
              </div>
              @endif

              {{-- <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.type') }} *</label>
              <div class="col-lg-4 col-md-9 col-sm-12">
                <select class="form-control kt-select2 {{ $errors->has('type_id') ? ' is-invalid' : '' }}"
                  id="kt_select2_1" name="type_id">
                  @foreach ( $userTypes as $userType )
                  <option {{ old('type_id',$user->type_id) == $userType->id ? 'selected' : '' }}
                    value="{{ $userType->id }}"> {{ $userType->title }}</option>
                  @endforeach
                </select>
                @if ($errors->has('type_id'))
                <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                @endif
              </div>
          </div> --}}

          <input type="hidden" name="type_id" value="{{$type}}">


          @if($type == 1  && Route::currentRouteName() != 'admin.profile.edit')
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 {{ $errors->has('role') ? ' is-invalid' : '' }}" id="kt_select2_2"
                name="role">
                @foreach ( $roles as $role )
                <option {{ old('role',optional($user->roles()->first())->id) == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                  {{ $role->title }}</option>
                @endforeach
              </select>
              @if ($errors->has('role'))
              <span class="invalid-feedback">{{ $errors->first('role') }}</span>
              @endif
            </div>
          </div>
          @endif


          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="image" class="dropify" data-default-file="{{ $user->imagePath() }}" />
            </div>


            <div class="col-lg-2 col-md-3 col-sm-4">

              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#image-{{$user->id}}">
                <i class="fas fa-search-plus"></i>
              </button>
              <div class="modal  fade" id="image-{{$user->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
  
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $user->image ? asset('storage/app/'.$user->image)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          @if($type == 3)
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.area') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 area" onchange="getCities($(this).val())" id="kt_select2_1"
                name="area">
                @foreach ( $areas as $area )
                <option @if($area->id == $user->area) selected @endif value="{{ $area->id }}">
                  {{ $area->translation('ar') }}
                </option>
                @endforeach
              </select>

            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.city') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 cities" id="kt_select2_2" name="city">
                @foreach ( $cities as $city )
                <option @if($city->id == $user->city) selected @endif value="{{ $city->id }}">
                  {{ $city->translation('ar') }}
                </option>
                @endforeach
              </select>

            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.id_number') }}</label>
            <div class=" col-lg-4 col-md-9 col-sm-12">
              <input id="id_number" type="text" class="form-control @error('id_number') is-invalid @enderror"
                maxlength="10" name="id_number" placeholder="{{ __('user.id_number') }}"
                value="{{ old('id_number',$user->id_number) }}">
              @if ($errors->has('id_number'))
              <span class="invalid-feedback">{{ $errors->first('id_number') }}</span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.id_card') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="id_card" class="dropify"
                data-default-file="{{ asset('storage/app/'.$user->id_card)  }}" />
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4">

              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#id_card-{{$user->id}}">
                <i class="fas fa-search-plus"></i>
              </button>
              <div class="modal  fade" id="id_card-{{$user->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
  
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $user->id_card ? asset('storage/app/'.$user->id_card)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.license') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="license" class="dropify"
                data-default-file="{{ asset('storage/app/'.$user->license)  }}" />
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4">

              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#license-{{$user->id}}">
                <i class="fas fa-search-plus"></i>
              </button>
              <div class="modal  fade" id="license-{{$user->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
  
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $user->license ? asset('storage/app/'.$user->license)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      
            
          </div>
          <!--
          <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">نوع الهوية </label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  <select class="form-control kt-select2 {{ $errors->has('identityTypeId') ? ' is-invalid' : '' }}"
                    id="kt_select2_3" name="identityTypeId">
                    @if($user->identityTypeId == null)
                      <option value ="" selected>اختر نوع الهويه</option>
                    @endif
                    <option {{ old('identityTypeId',$user->identityTypeId) == 'NV25GlPuOnQ=' ? 'selected' : '' }} value="NV25GlPuOnQ=">
                    هوية وطنية</option>
                      <option {{ old('identityTypeId',$user->identityTypeId) == 'oIcaYzeDfQQ=' ? 'selected' : '' }} value="oIcaYzeDfQQ=">
                      إقامة </option>
                      
                  </select>
                  @if ($errors->has('gender'))
                  <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                  @endif
                </div>
              </div>
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.id_card') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="id_card" class="dropify"
                data-default-file="{{ asset('storage/app/'.$user->id_card)  }}" />
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4">

              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#id_card-{{$user->id}}">
                <i class="fas fa-search-plus"></i>
              </button>
              <div class="modal  fade" id="id_card-{{$user->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
  
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $user->id_card ? asset('storage/app/'.$user->id_card)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.carType') }} </label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                  <select class="form-control kt-select2 {{ $errors->has('carType') ? ' is-invalid' : '' }}"
                    id="kt_select2_3" name="carType">
                    <option {{ old('gender',$user->carType) == 'NV25GlPuOnQ=' ? 'selected' : '' }} value="NV25GlPuOnQ=">
                      خاص</option>
                      <option {{ old('gender',$user->carType) == 'Nap4gA1tyeY=' ? 'selected' : '' }} value="Nap4gA1tyeY=">
                      نقل عام</option>
                      <option {{ old('gender',$user->carType) == 'oIcaYzeDfQQ=' ? 'selected' : '' }} value="oIcaYzeDfQQ=">
                      نقل خاص</option>
                      <option {{ old('gender',$user->carType) == 'w+mTCW1569Y=' ? 'selected' : '' }} value="w+mTCW1569Y=">
                      حافلة صغيرة عامة</option>
                      <option {{ old('gender',$user->carType) == 'rAy9UhMUw6Y=' ? 'selected' : '' }} value="rAy9UhMUw6Y=">
                      حافله صغيره خاص</option>
                      <option {{ old('gender',$user->carType) == 'A/VaSUhyG28=' ? 'selected' : '' }} value="A/VaSUhyG28=">
                      أجره</option>
                      <option {{ old('gender',$user->carType) == 'vXChcFPkxcI=' ? 'selected' : '' }} value="vXChcFPkxcI=">
                      أشغال عامه</option>
                      <option {{ old('gender',$user->carType) == '7kRgMtOkdQE=' ? 'selected' : '' }} value="7kRgMtOkdQE=">
                      تصدير</option>
                      <option {{ old('gender',$user->carType) == 'cABXRPle08s=' ? 'selected' : '' }} value="cABXRPle08s=">
                      دبلوماسي</option>
                      <option {{ old('gender',$user->carType) == 'J4DRtp+fYEM=' ? 'selected' : '' }} value="J4DRtp+fYEM=">
                      مؤقت</option>
                    
                  </select>
                  @if ($errors->has('gender'))
                  <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                  @endif
                </div>
              </div>



          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.carNum') }}</label>
            <div class=" col-lg-4 col-md-9 col-sm-12">
              <input id="carNumber" type="text" class="form-control @error('carNumber') is-invalid @enderror"
                maxlength="10" name="carNumber" placeholder="{{ __('user.carNum') }}"
                value="{{ old('carNumber',$user->carNumber) }}">
              @if ($errors->has('carNumber'))
              <span class="invalid-feedback">{{ $errors->first('carNumber') }}</span>
              @endif
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.carSequenceNum') }}</label>
            <div class=" col-lg-4 col-md-9 col-sm-12">
              <input id="vehicleSequenceNumber" type="text" class="form-control @error('vehicleSequenceNumber') is-invalid @enderror"
                maxlength="10" name="vehicleSequenceNumber" placeholder="{{ __('user.carSequenceNum') }}"
                value="{{ old('vehicleSequenceNumber',$user->vehicleSequenceNumber) }}">
              @if ($errors->has('vehicleSequenceNumber'))
              <span class="invalid-feedback">{{ $errors->first('vehicleSequenceNumber') }}</span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.license') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="license" class="dropify"
                data-default-file="{{ asset('storage/app/'.$user->license)  }}" />
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4">

              <button class="btn btn-success" type="button" data-toggle="modal" data-target="#license-{{$user->id}}">
                <i class="fas fa-search-plus"></i>
              </button>
              <div class="modal  fade" id="license-{{$user->id}}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
  
                    <div class="modal-content">
                      <div class="modal-body" style=" text-align: center;">
                        <img style="width : 100% " src="{{ $user->license ? asset('storage/app/'.$user->license)  : $emptyImage }}" class="  img-responsive ">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      
            
          </div>


-->

          @endif


          <x-buttons.but_submit />

          </form>

        </div>
      </div>

      @if($type == 3)
      <div class="kt-portlet__body " style="   overflow-x: scroll;">
        <table class="table table-striped- table-bordered table-hover table-checkable ">
          @php $ordersIds =\App\Models\Order::where(['shipper_id'=>$user->id,'status'=>4])->pluck('id') @endphp
          <tbody>
            <tr>
              <td></td>
              <td>{{ __('commission.orders_price') }}</td>
              <td>{{ __('commission.shipping_price') }}</td>
              <td>{{ __('commission.shipper_amount') }}</td>
              <td>{{ __('commission.commissions') }}</td>
              <td>{{ __('commission.discounts') }}</td>
              <td>{{ __('commission.cash') }}</td>
              <td>{{ __('commission.walet') }}</td>
              <td>{{ __('commission.online') }}</td>
              <td>{{ __('commission.charge_wallet') }}</td>
              <td>{{ __('commission.deserved_amount') }}</td>

            </tr>
            <tr>
              <td>{{ __('commission.not_paid_commissions') }}</td>
              <td>{{ $user->orders_price($ordersIds, 0) }} ريال  </td>
              <td>{{ $user->shipping_price($ordersIds, 0) }} ريال  </td>
              <td>{{ $user->shipper_amount($ordersIds, 0) }} ريال  </td>
              <td style="color: green ; font-weight: bold;" >{{ $user->commission($ordersIds, 0) }} ريال  </td>
              <td>{{ $user->discount($ordersIds, 0) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,1, 0) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,2, 0) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,3, 0) }} ريال  </td>
              <td>{{ $user->charge_wallet($ordersIds, 0) }} ريال  </td>
              <td style="color: red ; font-weight: bold;">{{ $user->deserved_amount($ordersIds, 0) }} ريال  </td>

            </tr>
            <tr>
              <td>{{ __('commission.paid_commissions') }}</td>
              <td>{{ $user->orders_price($ordersIds, 1) }} ريال  </td>
              <td>{{ $user->shipping_price($ordersIds, 1) }} ريال  </td>
              <td>{{ $user->shipper_amount($ordersIds, 1) }} ريال  </td>
              <td style="color: green ; font-weight: bold;"> {{ $user->commission($ordersIds, 1) }} ريال  </td>
              <td>{{ $user->discount($ordersIds, 1) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,1, 1) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,2, 1) }} ريال  </td>
              <td>{{ $user->payment($ordersIds,3, 1) }} ريال  </td>
              <td>{{ $user->charge_wallet($ordersIds, 1) }} ريال  </td>
              <td style="color: red ; font-weight: bold;" >{{ $user->deserved_amount($ordersIds, 1) }} ريال  </td>

            </tr>
          </tbody>
        </table>

      </div>
      @endif

    </div>
  </div>
</div>
</div>



@section('js_pagelevel')
<x-admin.dropify-js />

<script>
  function getCities(val) {
      if(val) {
        console.log('test');
          $.ajax({
              type: "get",
              url: "{{route('admin.shippers.cities')}}",
              data:{"id": val},
              success: function(data){
                console.log(data);
                  $(".cities").html(data);
               }
          }); 
      }
  }
</script>
@endsection

@endsection