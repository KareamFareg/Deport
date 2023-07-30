@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ __('words.add') }} &nbsp;&nbsp;&nbsp;
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">
            <!-- form -->
            <form class="kt_form_1" enctype="multipart/form-data" action="{{route("admin.$typeName.store")}}" method="post">
              {{ csrf_field() }}


              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.name') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                    maxlength="150" value="{{ old('name') }}" name="name" placeholder="{{ __('user.name') }}">
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
                    value="{{ old('email') }}" maxlength="50" @if ($type == 1)  @endif autocomplete="email">
                  @if ($errors->has('email'))
                  <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.password') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="password" type="password" placeholder="{{ __('words.password') }}"
                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required
                    autocomplete="current-password" minlength="6" maxlength="12">
                  @if ($errors->has('password'))
                  <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                  @endif
                </div>
              </div>


              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('auth.confirm_password') }} *</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    minlength="6" maxlength="12" placeholder="{{ __('auth.confirm_password') }}" required autocomplete="new-password">
                  @if ($errors->has('password_confirmation'))
                  <span class="invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.phone') }}</label>
                <div class=" col-lg-4 col-md-9 col-sm-12">
                  <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required placeholder="{{ __('words.phone') }}"
                    maxlength="10" name="phone" value="{{ old('phone') }}">
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
                    <option {{ old('gender') == 'male' ? 'selected' : '' }} value="male">{{__('user.male')}}</option>
                    <option {{ old('gender') == 'female' ? 'selected' : '' }} value="female">{{__('user.female')}}
                    </option>
                  </select>
                  @if ($errors->has('gender'))
                  <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                  @endif
                </div>
              </div>

              {{-- <div class="form-group row" >
                <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.type') }} *</label>
              <div class="col-lg-4 col-md-9 col-sm-12">
                <select class="form-control kt-select2 {{ $errors->has('type_id') ? ' is-invalid' : '' }}"
                  id="kt_select2_1" name="type_id">
                  @foreach ( $userTypes as $userType )
                  <option {{ old('type_id') == $userType->id ? 'selected' : '' }} value="{{ $userType->id }}">
                    {{ $userType->title }}</option>
                  @endforeach
                </select>
                @if ($errors->has('type_id'))
                <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
                @endif
              </div>
          </div> --}}

          <input type="hidden" name="type_id" value="{{$type}}">
          <input type="hidden" name="typeName" value="{{$typeName}}">


          @if ($type == 1)
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 {{ $errors->has('role') ? ' is-invalid' : '' }}" id="kt_select2_2"
                name="role">
                @foreach ( $roles as $role )
                <option {{ old('role') == $role->id ? 'selected' : '' }} value="{{ $role->id }}"> {{ $role->title }}
                </option>
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
              <input type="file" name="image" class="dropify" data-default-file="" />
            </div>
          </div>
          @if ($type == 3)
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.area') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 area" onchange="getCities($(this).val())"  id="kt_select2_1"
                name="area">
                @foreach ( $areas as $area )
                <option value="{{ $area->id }}"> {{ $area->translation('ar') }}
                </option>
                @endforeach
              </select>
  
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.city') }} *</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <select class="form-control kt-select2 cities"  id="kt_select2_2"
                name="city">
                @foreach ( $cities as $city )
                <option value="{{ $city->id }}"> {{ $city->translation('ar') }}
                </option>
                @endforeach
              </select>
  
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.id_number') }}</label>
            <div class=" col-lg-4 col-md-9 col-sm-12">
              <input id="id_number" type="text" class="form-control @error('id_number') is-invalid @enderror"
                maxlength="10" name="id_number" placeholder="{{ __('user.id_number') }}" value="{{ old('id_number') }}">
              @if ($errors->has('id_number'))
              <span class="invalid-feedback">{{ $errors->first('id_number') }}</span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.id_card') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="id_card" class="dropify" data-default-file="" />
            </div>
          </div>


          <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.license') }} Max 500 KB</label>
            <div class="col-lg-4 col-md-9 col-sm-12">
              <input type="file" name="license" class="dropify" data-default-file="" />
            </div>
          </div>
          @endif


          <x-buttons.but_submit />
          </form>
        </div>
      </div>
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