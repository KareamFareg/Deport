@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <x-buttons.but_back link="{{ route('admin.users.index') }}"/>
               
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.users.update', [ 'id' => $user->id ] )}}" method="post">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required maxlength="150"
        value="{{ old('name', $user->name) }}" name="name" placeholder="">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('name'))
                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.email') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input id="email" type="email" autocomplete="off" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
        name="email" value="{{ old('email',$user->email) }}" maxlength="50" required autocomplete="email">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('email'))
                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.password') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" autocomplete="current-password" minlength="8" maxlength="12">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('password'))
                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-form-label col-lg-3 col-sm-12">{{ __('auth.confirm_password') }}</label>
        <div class="col-lg-4 col-md-9 col-sm-12">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="8" maxlength="12" autocomplete="new-password">
        </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.phone') }}</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required maxlength="11" name="phone" value="{{ old('phone',$user->phone) }}">
        @if ($errors->has('phone'))
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.type') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('type_id') ? ' is-invalid' : '' }}" id="kt_select2_1" name="type_id">
          @foreach ( $userTypes as $userType )
            <option {{ old('type_id',$user->type_id) == $userType->id ? 'selected' : '' }} value="{{ $userType->id }}"> {{ $userType->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('type_id'))
            <span class="invalid-feedback">{{ $errors->first('type_id') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('role') ? ' is-invalid' : '' }}" id="kt_select2_2" name="role">
          @foreach ( $roles as $role )
            <option {{ old('role',$user->role) == $role->id ? 'selected' : '' }} value="{{ $role->id }}"> {{ $role->title }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('role'))
            <span class="invalid-feedback">{{ $errors->first('role') }}</span>
        @endif
      </div>
    </div>



    @if ( request()->user()->isAdmin() )
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('user.client') }}</label>
      <div class="col-lg-4 col-md-9 col-sm-12">
        <select class="form-control kt-select2 {{ $errors->has('client_id') ? ' is-invalid' : '' }}" id="kt_select2_3" name="client_id">
          <option {{ old('client_id') == 0 ? 'selected' : '' }} value="0">------------</option>
          @foreach ( $clients as $client )
            <option {{ old('client_id',$user->client_id) == $client->id ? 'selected' : '' }} value="{{ $client->id }}"> {{ $client->name }}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('client_id'))
            <span class="invalid-feedback">{{ $errors->first('client_id') }}</span>
        @endif
      </div>
    </div>
    @endif


    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ $user->imagePath() }}" />
      </div>
    </div>


    <x-buttons.but_submit/>

</form>





          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@section('js_pagelevel')
<x-admin.dropify-js/>
@endsection

@endsection
