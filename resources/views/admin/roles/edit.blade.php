@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <x-buttons.but_back link="{{ route('admin.roles.index') }}"/>
               
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data" action="{{route('admin.roles.update', [ 'id' => $role->id ] )}}" method="post">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">

    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.name') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100"
        value="{{ old('title' , $role->title) }}" name="title" placeholder="{{ __('role.name') }}">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
        @endif
      </div>
    </div>
    
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.level') }} *</label>
      <div class=" col-lg-4 col-md-9 col-sm-12">
        <input type="number" min="1" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" required maxlength="100"
        value="{{ old('level' , $role->level) }}" name="level" placeholder="{{ __('role.level') }}">
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('level'))
            <span class="invalid-feedback">{{ $errors->first('level') }}</span>
        @endif
      </div>
    </div>

    <input type="hidden" name="role_for" value="0">
    {{--
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12"> *</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="kt-checkbox-list">
          <label class="kt-checkbox">
            <input type="checkbox" name="role_for" value="1" {{ $role->role_for ? 'checked' : '' }}>{{ __('role.role_for') }}
            <span></span>
          </label>
        </div>
        <!-- <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span> -->
      </div>
    </div>
    --}}


{{--
    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="kt-checkbox-list">
            @foreach ($privilegesAll as $privilege)
          <label class="kt-checkbox">
            <input type="checkbox"
            @if (array_search( $privilege->id , $rolePrivileges ) !== (bool) false )
              checked
            @endif
            value="{{ $privilege->id }}" name="privileges[]">
            {{ $privilege->title }}
            <span></span>
          </label>
          @endforeach
        </div>
        <!-- <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span> -->
      </div>
    </div>
  --}}



    <div class="form-group row">
      <label class="col-form-label col-lg-3 col-sm-12">{{ __('role.title') }} *</label>
      <div class="col-lg-9 col-md-9 col-sm-12">
        <div class="kt-checkbox-list">
          @foreach ($privilegesTree as $privilege)
            <div style="padding-right: {{ $privilege->depth * 25 }}px;margin: 13px;">
              <label class="kt-checkbox">
                <input type="checkbox" value="{{ $privilege->id }}"  onclick="markChecked($(this),'{{$privilege->id}}')" class="parent_id_{{$privilege->parent_id}} role_id_{{$privilege->id}}" name="privileges_ids[]" @if (array_search( $privilege->id , $rolePrivileges ) !== (bool) false ) checked  @endif >{{ $privilege->title }}
                <span></span>
              </label>
            </div>
          @endforeach
        </div>
        <!-- <span class="form-text text-muted">Please select at lease 1 and maximum 2 options</span> -->
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
<script>
  function markChecked(this_role,id){
    $(".parent_id_"+id).prop('checked', this_role.prop("checked"));
  }
</script>
@endsection

@endsection
