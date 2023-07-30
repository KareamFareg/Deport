@extends('admin.layouts.master')

@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
  <div class="row">
    <div class="col-lg-12">

      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              <div class="row">
              <x-buttons.but_back link="{{ route('admin.clients.index') }}"/>
               
              <x-admin.trans-bar :languages="$languages" route="{{ route('admin.clients.edit' , ['id' => $data->id ] ) }}" :trans="$trans"/>
              </div>
            </h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <div class="kt-section kt-section--first">





<!-- form -->
<form class="kt_form_1" enctype="multipart/form-data"
    @if ($data->client_info->isEmpty())
      action="{{route('admin.clients.store_trans',[ 'id'=> $data->id ]) }}" method="post"
    @else
      action="{{route('admin.clients.update' , ['id' => $data->client_info->first()->id ])}}"  method="post"
    @endif>

    @if (!$data->client_info->isEmpty())
    <input name="_method" type="hidden" value="PUT">
    @endif

    {{ csrf_field() }}

          يرجى العلم انه عند تعديل اي بيانات فسيتم تعطيل الحساب مؤقتا وتسجيل الخروج تلقائيا لحين الموافقة على تعديل البيانات من ادارة المنصة.
          <br>
          <br>
    <input type="hidden" value="{{ $trans }}" name="language">

    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('words.shop_name') }}</label>
        <div class="col-md-9">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name' , optional($data->client_info->first())->title ) }}" maxlength="150" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('words.email') }}</label>
        <div class="col-md-9">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email' , $data->email ) }}" autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('words.password') }}</label>
        <div class="col-md-9">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
            minlength="8" maxlength="12" autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('auth.confirm_password') }}</label>
        <div class="col-md-9">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" minlength="8" maxlength="12" autocomplete="new-password">
        </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('country.title') }} *</label>
      <div class=" col-lg-9">
        <select class="form-control kt-select2 {{ $errors->has('country_id') ? ' is-invalid' : '' }}" required id="kt_select2_2" name="country_id">
          @foreach ( $countries as $country )
            <option {{ old('country_id', $data->country_id ) == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}  {{str_repeat('__', $country->depth)}}</option>
          @endforeach
        </select>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('country_id'))
            <span class="invalid-feedback">{{ $errors->first('country_id') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.mobile') }} *</label>
      <div class=" col-lg-9">
        <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" required maxlength="10" name="mobile"
        value="{{ old('mobile' , $data->mobile ) }}">
        @if ($errors->has('mobile'))
            <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.phone') }}</label>
      <div class=" col-lg-9">
        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" required maxlength="10" name="phone"
        value="{{ old('phone' , $data->phone) }}">
        @if ($errors->has('phone'))
            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.contacts') }}</label>
      <div class=" col-lg-9">
        <textarea class="form-control {{ $errors->has('contacts') ? ' is-invalid' : '' }}" max="4000" name="contacts" placeholder="" rows="6">{{ old('contacts' , $data->contacts ) }}</textarea>
        @if ($errors->has('contacts'))
            <span class="invalid-feedback">{{ $errors->first('contacts') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('auth.administrator') }} *</label>
      <div class=" col-lg-9">
        <input id="administrator" type="text" class="form-control @error('administrator') is-invalid @enderror" required maxlength="200" name="administrator" value="{{ old('administrator', $data->administrator) }}">
        @if ($errors->has('administrator'))
            <span class="invalid-feedback">{{ $errors->first('administrator') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('client.commerce_no') }}</label>
      <div class=" col-lg-9">
        <textarea class="form-control {{ $errors->has('commerce_no') ? ' is-invalid' : '' }}" max="500" required name="commerce_no" placeholder="" rows="6">{{ old('commerce_no' , $data->commerce_no) }}</textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('commerce_no'))
            <span class="invalid-feedback">{{ $errors->first('commerce_no') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('auth.work_times') }}</label>
      <div class="col-lg-9">
        <textarea class="form-control {{ $errors->has('work_times') ? ' is-invalid' : '' }}" max="1000" name="work_times" placeholder="" rows="6">{{ old('work_times' , optional($data->client_info->first())->work_times ) }}</textarea>
        @if ($errors->has('work_times'))
            <span class="invalid-feedback">{{ $errors->first('work_times') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('category.title') }} *</label>
      <div class=" col-lg-9">
        @foreach ($categories as $category)
        {{str_repeat('.....', $category->depth)}}
        <label class="kt-checkbox">
          <input type="checkbox"  value="{{ $category->id }}"
          {{ ( in_array($category->id, old('categories', $data->categories )) )  ? 'checked' : '' }}
          name="categories[]">{{ $category->title }}
          <span></span>
        </label>
        <br>
        @endforeach
        @if ($errors->has('categories'))
            <span class="invalid-feedback">{{ $errors->first('categories') }}</span>
        @endif
      </div>
    </div>


    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.logo') }}</label>
      <div class="col-lg-9">
        <input type="file" name="logo" id="input-file-now-custom-1" class="dropify" data-default-file="{{ optional($data->client_info->first())->logoPath() }}" />
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.banner') }}</label>
      <div class="col-lg-9">
        <input type="file" name="banner" id="input-file-now-custom-1" class="dropify" data-default-file="{{ optional($data->client_info->first())->bannerPath() }}" />
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.address') }}</label>
      <div class=" col-lg-9">
        <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" max="4000" name="address" placeholder="" rows="6">{{ old('address' , optional($data->client_info->first())->address ) }}</textarea>
        <!-- <span class="form-text text-muted">Please enter your full name</span> -->
        @if ($errors->has('address'))
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right"></label>
      <div class="col-lg-9">
        <div id="map" style="width: auto;height: 500px;"></div>
        <input type="hidden" name="lat" id="lat" value="{{ $data->user->lat }}">
        <input type="hidden" name="lng" id="lng" value="{{ $data->user->lng }}">
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">{{ __('words.description') }}</label>
      <div class=" col-lg-9">
        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" max="4000" name="description" placeholder="" rows="6">{{ old('description' , optional($data->client_info->first())->description ) }}</textarea>
        @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
        @endif
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
<x-admin.google-map-js :lat="$data->user->lat" :lng="$data->user->lng"/>
@endsection

@endsection
