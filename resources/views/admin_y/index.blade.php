@extends('admin.layouts.master')

@section('content')

<!-- home page -->



<!-- general widgets -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

  <!--begin:: Widgets/Stats-->
  <div class="kt-portlet">
    <div class="kt-portlet__body  kt-portlet__body--fit">
      <div class="row row-no-padding row-col-separator-xl">

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.users') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['usersCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Feedbacks-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.clients_count') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Customer Review -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-warning">
                {{ $data['clientsCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::New Feedbacks-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Orders-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.delegates_count') }}
                </h4>
                <span class="kt-widget24__desc">
                  {{ __('words.avaliable') }} : {{ $data['delegatesCountAvaliable'] }}&nbsp;&nbsp;&nbsp;
                  {{ __('words.not_avaliable') }} : {{ $data['delegatesCountNotAvaliable'] }}
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-danger">
                {{ $data['delegatesCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::New Orders-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3"></div>


         <!-- عدد الطلبات -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.orders_count') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['ordersCount'] }}
                @php
                  if ($data['ordersCount'] == 0) {
                    $ordersCount = 1 ;
                  } else {
                    $ordersCount = $data['ordersCount'];
                  }
                @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>
        <div class="col-md-12 col-lg-6 col-xl-3"></div>
        <div class="col-md-12 col-lg-6 col-xl-3"></div>
        <div class="col-md-12 col-lg-6 col-xl-3"></div>

        <!-- 01 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_1') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['OrderCreated'] }}
                @php $pers = ( $data['OrderCreated'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }} %
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 02 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_2') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['OrderAccepted'] }}
                @php $pers = ( $data['OrderAccepted'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 03 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_3') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderProcessing'] }}
                @php $pers = ( $data['orderProcessing'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 04 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_4') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderDone'] }}
                @php $pers = ( $data['orderDone'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 05 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_5') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderCanceled'] }}
                @php $pers = ( $data['orderCanceled'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 06 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_6') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderComment'] }}
                @php $pers = ( $data['orderComment'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 07 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_7') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderCreateContract'] }}
                @php $pers = ( $data['orderCreateContract'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        <!-- 08 -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Users-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('order.status_8') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Joined New User -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-success">
                {{ $data['orderCreateBill'] }}
                @php $pers = ( $data['orderCreateBill'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-success" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::New Users-->
        </div>

        @if ( auth()->user()->isAdmin() )
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.order_shop_prim') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['orderShopPrim'] }}
                @php $pers = ( $data['orderShopPrim'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.order_shop') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['orderShop'] }}
                @php $pers = ( $data['orderShop'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.car_transport') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['carTransport'] }}
                @php $pers = ( $data['carTransport'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.car_transport_cities') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['carTransportCities'] }}
                @php $pers = ( $data['carTransportCities'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.air') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['air'] }}
                @php $pers = ( $data['air'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.transport') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['transport'] }}
                @php $pers = ( $data['transport'] / $ordersCount ) * 100 ; $pers = (int)$pers ; @endphp
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: {{ $pers }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                {{ $pers }}%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>

        <div class="col-md-12 col-lg-6 col-xl-3"></div>
        <div class="col-md-12 col-lg-6 col-xl-3"></div>
        @endif

        <!-- انتهاء الطلبات -->



        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Orders-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.items_count') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-danger">
                {{ $data['itemsCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::New Orders-->
        </div>

        @if ( auth()->user()->isAdmin() )
        <!-- سيارات -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::Total Profit-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.cars_count') }}
                </h4>
                <span class="kt-widget24__desc">

                </span>
              </div>
              <span class="kt-widget24__stats kt-font-brand">
                {{ $data['carsCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::Total Profit-->
        </div>
        <!-- رحلات طائرات -->
        <div class="col-md-12 col-lg-6 col-xl-3">
          <!--begin::New Feedbacks-->
          <div class="kt-widget24">
            <div class="kt-widget24__details">
              <div class="kt-widget24__info">
                <h4 class="kt-widget24__title">
                  {{ __('admin/dashboard.airs_count') }}
                </h4>
                <span class="kt-widget24__desc">
                  <!-- Customer Review -->
                </span>
              </div>
              <span class="kt-widget24__stats kt-font-warning">
                {{ $data['airsCount'] }}
              </span>
            </div>
            <div class="progress progress--sm">
              <div class="progress-bar kt-bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="kt-widget24__action">
              <span class="kt-widget24__change">
                <!-- Change -->
              </span>
              <span class="kt-widget24__number">
                100%
              </span>
            </div>
          </div>
          <!--end::New Feedbacks-->
        </div>
        @endif



      </div>
    </div>
  </div>

  <!--end:: Widgets/Stats-->

</div>

<!-- End general widgets -->









@endsection
