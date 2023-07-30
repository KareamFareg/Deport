@extends('front.layouts.master')

@section('content')

<x-front.MainSlider/>

<div class="mob-main-sections">
  <div class="container">
    <div class="card shadow-sm bg-white">
      <ul class="list-unstyled no-margin">
        <li class="active"><a href="{{ route('front.home') }}"><img src="{{ asset('assets/front/images/select-all.svg') }}" class="img-fluid" alt="icon"> عرض الكل</a></li>
        <li><a href="{{ route('front.offers') }}"><img src="{{ asset('assets/front/images/discount.svg') }}" class="img-fluid" alt="icon"> عروض</a></li>
        <li><a href="{{ route('front.coupons') }}"><img src="{{ asset('assets/front/images/coupon.svg') }}" class="img-fluid" alt="icon">كوبونات</a></li>
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

        <div class="add-post">
          <x-FlashAlert/>
          <div class="card shadow-sm">
            <div class="card-header">
              <div class="media">
                <img src="{{ auth()->user()->imagePath() }}" class="ml-1" alt="">
                <div class="media-body">
                  <!-- <form action=""> -->
                    <div class="form-group">
                      <textarea name="description" id="description" class="form-control limited" form="frm_share" data-mintext="0" maxlength="200" data-maxtext="200" placeholder="شارك باضافة عرض او كوبون خصم ..."></textarea>
                    </div>
                  <!-- </form> -->
                  <div class="letters">
                      <p style="font-size: 12px;">الحد الاقصي للحروف <span>200</span></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="post-type">
                <a href="" data-toggle="modal" data-target="#selectType" class="btn btn-default">
                      <img src="{{ asset('assets/front/images/page-1.svg') }}" class="img-fluid" alt=""> نوع المشاركة
                    </a>
                <a href="#" class="btn btn-default ch-img" data-toggle="modal" data-target="#addImages">
                  <div class="upload-imgs">
                    <img src="{{ asset('assets/front/images/upload.svg') }}" class="img-fluid" alt="icon"> اضافة صورة
                  </div>
                </a>
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#addLink">
                  <div class="add-link">
                    <img src="{{ asset('assets/front/images/link2.svg') }}" class="img-fluid" alt="icon"> اضف رابط
                  </div>
                </a>
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#adsTime">
                      <i class="fas fa-clock"></i> مدة الاعلان
                    </a>
              </div>

              <div class="share-btn">
                <button class="btn btn-danger" onClick="submitForm();"><img src="{{ asset('assets/front/images/share-icon.svg') }}" class="img-fluid" alt="icon"> شارك</button>
              </div>
            </div>
          </div>
        </div>

        <div id='items_all'>
            <x-front.items :data="$data"/>
        </div>
        <div id="items_paginate">
              <x-front.paginate :nextUrl="$data->nextPageUrl()"/>
        </div>

    </div>

      <div class="col-lg-3 col-md-3 col-sm-12 order-3 order-lg-3 order-md-3 order-sm-3 order-xs-3">
        <x-front.SidebarImage2/>
        <x-front.TheMost currentMost='views'/>
        <x-front.DownloadApp/>
        <x-front.FollowUs/>
        <x-front.quick-links/>




                    {{--
                    <!-- form will be delete after test upload image-->
                    <form class="kt_form_1" enctype="multipart/form-data" action="{{route('test.upload.image')}}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group row">
                          <label class="col-form-label col-lg-3 col-sm-12">{{ __('words.image') }}</label>
                          <div class="col-lg-9 col-md-9 col-sm-12">
                            <input type="file" name="image" />
                          </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-danger shadow">upload</button>
                    </form>
                    --}}




      </div>


  </div>
  </div>
</main>



@section('js_pagelevel')
<x-admin.dropify-js/>
@endsection

@endsection
