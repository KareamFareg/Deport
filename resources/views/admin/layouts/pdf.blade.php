<!DOCTYPE html>
<!---->
<html lang="{{ app()->getLocale() }}">

<!-- begin::Head -->

<head>

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../">
    <title>{{ __($pageTitle ?? '') }}</title>
    <!--end::Base Path -->
    <meta charset="utf-8" />
    {{-- <title>@yield('pageTitle') -
        {{ $settings['app_title'] ?? config('app.name', 'ResCode Admin') }}</title> --}}

    <meta name="description" content="Base form control examples">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Scripts from laravel layout-->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- CSRF Token from laravel layout-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php $dir = (session('locale')['dir'] == 'rtl') ? 'rtl' : '' ; @endphp
    @include('admin.layouts.styles')


</head>
<!-- end::Head -->






<!-- begin::Body -->

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
    <!-- begin:: Page -->




    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">



            <!-- end:: Aside -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">



                <!-- end:: Header -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content"
                    style="direction: {{ $dir }} ;">



                    <!-- end:: Content Head -->

                    <!-- begin:: Content -->
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid"
                        style="direction: {{ $dir }} ;">

                        <!--Begin::Dashboard 1-->
                        @yield('content')



                        <!--End::Dashboard 1-->
                    </div>

                    <!-- end:: Content -->
                </div>



            </div>
        </div>
    </div>

    <!-- end:: Page -->









    @include('admin.layouts.scripts')


    <!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>