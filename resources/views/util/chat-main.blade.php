@extends('admin.layouts.master')

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

  <!-- begin:: Content -->
  <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

      <!--Begin:: App Aside Mobile Toggle-->
      <button class="kt-app__aside-close" id="kt_chat_aside_close">
        <i class="la la-close"></i>
      </button>

      <!--End:: App Aside Mobile Toggle-->


      <!--Begin:: App Content-->
      <div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
        <div class="kt-chat">
          <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
            <div class="kt-portlet__head">
              <div class="kt-chat__head ">

                <div class="kt-chat__left">
                  
                </div>


                <div class="kt-chat__center">
                  <div class="kt-chat__label">
                    <a  class="kt-chat__title">{{ __('words.chat') }} : {{ $order->id }} - {{ optional($order->category->translation->first())->title }}</a>
                    <span class="kt-chat__status">
                      <span class="kt-badge kt-badge--dot kt-badge--success"></span>
                      {{ optional($order->user_data)->name ?? __('words.deleted')  }} {{ optional($order->user_data)->phone }} -
                      {{ optional(optional(optional(optional($order->shop)->client)->translation)->first())->title }} -
                      {{ optional($order->accept)->title }}
                    </span>
                  </div>
                
                </div>


                <div class="kt-chat__right">
                 
                </div>

              </div>
            </div>
            <div class="kt-portlet__body">
              <div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
                <div style="overflow-y: scroll; height:400px;" class="kt-chat__messages">
                  @if(!empty($items))
                  @foreach($items as $key => $item)

                      @if ( $item['receiverId'] == $chaters_ids['receiver_id'] )
                          <div class="kt-chat__message">
                            <div class="kt-chat__user">
                              <!-- <span class="kt-userpic kt-userpic--circle kt-userpic--sm">
                                <img src="./assets/media/users/100_12.jpg" alt="image">
                              </span> -->
                              <a href="#" class="kt-chat__username">{{ $chaters['receiver_name'] }}</span></a>
                              <span class="kt-chat__datetime">{{ isset($item['time']) ? $item['time'] : '' }}</span>
                            </div>
                            <div class="kt-chat__text kt-bg-light-success">
                              @if ($item['type'] == 'text')  <x-chat.string :text="$item['message']"/> @endif
                              @if ($item['type'] == 'audio')  <x-chat.audio :file="$item['message']"/> @endif
                              @if ($item['type'] == 'image')  <x-chat.image :key="$key" :file="$item['message']"/> @endif
                              @if ($item['type'] == 'location')
                                @php $lat = explode(',', $item['message'] )[0];  @endphp
                                @php $lng = explode(',', $item['message'] )[1];  @endphp
                                <div id="map_recev_{{ $key }}" class="map" lat="{{ $lat }}" lng="{{ $lng }}" style="width:500px; height:500px"></div>
                              @endif
                            </div>
                          </div>
                      @else
                          <div class="kt-chat__message kt-chat__message--right">
                            <div class="kt-chat__user">
                              <!-- <span class="kt-userpic kt-userpic--circle kt-userpic--sm">
                                <img src="./assets/media/users/100_12.jpg" alt="image">
                              </span> -->
                              <a href="#" class="kt-chat__username">{{ $chaters['sender_name'] }}</span></a>
                              <span class="kt-chat__datetime">{{ isset($item['time']) ? $item['time'] : '' }}</span>
                            </div>
                            <div class="kt-chat__text kt-bg-light-success">
                              @if ($item['type'] == 'text')  <x-chat.string :text="$item['message']"/> @endif
                              @if ($item['type'] == 'audio')  <x-chat.audio :file="$item['message']"/> @endif
                              @if ($item['type'] == 'image')  <x-chat.image :key="$key" :file="$item['message']"/> @endif
                              @if ($item['type'] == 'location')
                                @php $lat = explode(',', $item['message'] )[0];  @endphp
                                @php $lng = explode(',', $item['message'] )[1];  @endphp
                                <div id="map_recev_{{ $key }}" class="map" lat="{{ $lat }}" lng="{{ $lng }}" style="width:500px; height:500px"></div>
                              @endif
                            </div>
                          </div>
                      @endif

                      @php $curuser = $item['receiverId']; @endphp

                  @endforeach
                  @endif
                </div>
              </div>
            </div>

          

          </div>
        </div>
      </div>

      <!--End:: App Content-->
    </div>

    <!--End::App-->
  </div>

  <!-- end:: Content -->
</div>


@section('js_pagelevel')
<x-admin.google-map-chat-js />
@endsection

@endsection
