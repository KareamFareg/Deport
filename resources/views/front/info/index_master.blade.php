@extends('front.layouts.master')

@section('content')


<x-front.MainSlider/>



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
              <h4>{{ $currentItem }}</h4>
            </div>
            <div class="card-body">
              <div class="about-us">
                @isset($infoImage['value'])
                <img src="{{ asset('storage/app/'.$infoImage['value']) }}" class="img-fluid mx-auto" alt="">
                @endisset
                {!! $info['value'] !!}
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
