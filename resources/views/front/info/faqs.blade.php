@extends('layout.layout_front')

@section('css_Pagelevel')

@endsection

@section('pageTitle','Welcome')

@section('content')

<div class="tt-breadcrumb">
  @include('front.common.breadcrumb',['breadcrumb' => [],'currentItem'=>[$currentItem,''] ])
</div>

<div id="tt-pageContent">
  <div class="container-indent">
    <div class="container container-fluid-custom-mobile-padding">
      <h1 class="tt-title-subpages">{{ trans('front.qa') }}</h1>
      <div class="faq-search">
        <form method="post" action="{{ route('front.info.qa') }}">
          @csrf
              <div class="form-group">
                <input type="text" class="form-control" id="qa_search" name="qa_search" value="{{ $qa_search }}" placeholder="ادخل كلمة البحث">
                <button type="submit" class="btn btn-primary">{{ trans('front.search')}}</button>
              </div>
        </form>
      </div>
      
      <div class="faqs-list">
          @foreach($data as $q)
          <div class="tt-collapse">
            <div class="tt-collapse-title">{{ $q->question }}</div>
              <div class="tt-collapse-content in">
                <p>{!! $q->answer !!}</p>
              </div>
          </div>
          @endforeach
      </div>
      
    </div>
  </div>
</div>

@endsection
