@extends('front.layouts.master')

@section('content')


<x-front.main-slider/>



<div class="mob-main-sections">
  <div class="container">
    <div class="card shadow-sm bg-white">
      <ul class="list-unstyled no-margin">
        <li class="active"><a href="{{ route('front.home') }}"><img src="assets/images/select-all.svg" class="img-fluid" alt="icon"> عرض الكل</a></li>
        <li><a href="{{ route('front.offers') }}"><img src="assets/images/discount.svg" class="img-fluid" alt="icon"> عروض</a></li>
        <li><a href="{{ route('front.coupons') }}"><img src="assets/images/coupon.svg" class="img-fluid" alt="icon">كوبونات</a></li>
      </ul>
    </div>
  </div>
</div>





<main class="main-content" id="top">
  <div class="container">
    <div class="row d-flex">
      <div class="col-lg-3 col-md-3 col-sm-12 order-1 order-lg-1 order-md-1 order-sm-2 order-xs-2">

        <x-front.SidebarImage1/>

        <x-front.TheMost currentMost='likes'/>
        <x-front.TheMost currentMost='comments'/>

      </div>



      <div class="col-lg-6 col-md-6 col-sm-12 order-2 order-lg-2 order-md-2 order-sm-1 order-xs-1">
        <x-FlashAlert/>

        <div class="most-commented">
          <div class="card shadow-sm">
            <div class="card-header">
              <h4> تواصل معنا</h4>
            </div>
            <div class="card-body">
              <div class="contact-us">
                <div class="contact-info">
                  <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">الجوال</label>
                    <div class="col-sm-8">
                      <b class="text-dark">{{ $info['phone_1'] }}</b>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-labe">البريد الالكتروني</label>
                    <div class="col-sm-8">
                      <b class="text-dark">{{ $info['mail'] }}</b>
                    </div>
                  </div>
                </div>

                <div class="contact-form">
                  <form id="contactform" class="contact-form form-default" method="post" novalidate="novalidate" action="{{ route('front.info.contactusPost') }}">
                    @csrf
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">الاسم</label>
                      <div class="col-sm-7">
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" maxlength="100">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">الجوال</label>
                      <div class="col-sm-7">
                        <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{ old('mobile') }}" maxlength="10">
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">البريد الالكتروني</label>
                      <div class="col-sm-7">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" maxlength="50">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">نوع الرسالة</label>
                      <div class="col-sm-7">
                        <input type="hidden" name="type_info" id="type_info" value=''>
                        <select name="contact_us_type_id" id="contact_us_type_id" class="form-control @error('contact_us_type_id') is-invalid @enderror">
                          @foreach ($msg_types as $type)
                            <option @if ( old('contact_us_type_id') == $type->id ) selected @endif value="{{ $type->id }}">{{ $type->title }}</option>
                          @endforeach
                        </select>
                        @error('contact_us_type_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    {{--
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">عنوان الرسالة</label>
                      <div class="col-sm-7">
                        <input type="text" name="subject" class="form-control" id="subject" maxlength="100" value="{{ old('subject') }}">
                        @error('subject')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    --}}
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label">نص الرسالة</label>
                      <div class="col-sm-7">
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="12" maxlength="2000" id="msg_body">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="" class="col-sm-4 col-form-label"></label>
                      <div class="col-sm-7">
                        <div class="send-btn">
                            <button type="submit" class="btn  btn-danger btn-block btn-rounded shadow">{{ trans('words.send') }}</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="col-lg-3 col-md-3 col-sm-12 order-3 order-lg-3 order-md-3 order-sm-3 order-xs-3">
        <!-- <div class="side-ads d-none d-sm-block">
          <img src="assets/images/banner01.jpg" class="img-fluid mx-auto" alt="">
        </div> -->
        <x-front.SidebarImage2/>

        <x-front.TheMost currentMost='views'/>

        <x-front.DownloadApp/>
        <x-front.FollowUs/>

        <x-front.quick-links/>



      </div>
    </div>
  </div>
</main>



@section('js_pagelevel')

@endsection

@endsection
