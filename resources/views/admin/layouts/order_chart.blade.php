<link href="{{ asset('assets/admin/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />

<div class="kt-widget14__chart">
    <div id="order_charts" style="height: auto; width: 50%;"></div>
</div>
<div class="kt-widget14__legends">
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-primary"></span>
        <span class="kt-widget14__stats"> {{__('order.status_6') .' | '. $ordersCount6}}</span>
    </div>
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-dark "></span>
        <span class="kt-widget14__stats"> {{__('order.status_1') .' | '. $ordersCount1}}</span>
    </div>
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-brand"></span>
        <span class="kt-widget14__stats"> {{__('order.status_2') .' | '. $ordersCount2}}</span>
    </div>
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-warning"></span>
        <span class="kt-widget14__stats"> {{__('order.status_3') .' | '. $ordersCount3}}</span>
    </div>
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-success"></span>
        <span class="kt-widget14__stats"> {{__('order.status_4') .' | '. $ordersCount4}}</span>
    </div>
    <div class="kt-widget14__legend">
        <span class="kt-widget14__bullet kt-bg-danger"></span>
        <span class="kt-widget14__stats"> {{__('order.status_5') .' | '. $ordersCount5}}</span>
    </div>

</div>

<script src="{{ asset('assets/admin/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/admin/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>

<script>
    Morris.Donut({
          element: 'order_charts',
          data: [{
                  label: "{{__('order.status_1')}}",
                  value: "{{$ordersPercent1}}" 
              },
              {
                label: "{{__('order.status_2')}}",
                value: "{{$ordersPercent2}}" 
              },
              {
                label: "{{__('order.status_3')}}",
                value: "{{$ordersPercent3}}" 
              },
              {
                label: "{{__('order.status_4')}}",
                value: "{{$ordersPercent4}}" 
              },
              {
                label: "{{__('order.status_5')}}",
                value: "{{$ordersPercent5}}" 
              }
              
          ],
          colors: [
            '#282a3c','#5d78ff','#ffb821','#0bbb87','#fd397a'
          ],
      });
      
</script>