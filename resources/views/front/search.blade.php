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

        <div id='items_all'>
            <x-front.items :data="$data"/>
        </div>
        <div id="items_paginate">
              {{--<x-front.paginate :nextUrl="$data->nextPageUrl()"/>--}}
              {{--<x-front.paginate :nextUrl="route('front.search' , [ 'live_search' => request()->live_search ] ) . '&page=' . ($data->currentPage() + 1) "/>--}}
                <x-front.paginate :nextUrl="$nextUrl"/>
        </div>

      </div>

      <div class="col-lg-3 col-md-3 col-sm-12 order-3 order-lg-3 order-md-3 order-sm-3 order-xs-3">
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
<x-admin.dropify-js/>
@endsection

@endsection
