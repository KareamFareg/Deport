<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_Qajj9nMV6UZB_L8cAReXPdXeRoodnc8&callback=initMap&v=3.exp&?sensor=false">
</script>

<script>
  var maps = [];

   var markers = [];

   function initMap() {

       var $maps = $('.map');

       $.each($maps, function (i, value) {
        var sourceLat = parseFloat($(value).attr('lat'));
        var sourceLng = parseFloat($(value).attr('lng')) ;
        var destinationLat = parseFloat($(value).attr('lat2'));
        var destinationLng = parseFloat($(value).attr('lng2'));
        var mapDivId = $(value).attr('id');





if( destinationLat != null && destinationLng != null ){
  var uluru2 = new google.maps.LatLng(destinationLat,destinationLng);
  maps[mapDivId] = new google.maps.Map(document.getElementById(mapDivId), {
               center: uluru2,
               zoom: 13,
           });

           markers[mapDivId] = new google.maps.Marker({
               position: uluru2,
               map: maps[mapDivId],
               title: "destination",
               label: "{{__('order.from')}}",
           });
}


       
if( sourceLat != null && sourceLng != null ){
  var uluru = new google.maps.LatLng(sourceLat,sourceLng);
  markers[mapDivId] = new google.maps.Marker({
               position: uluru,
               map: maps[mapDivId],
               title: "source",
              label: "{{__('order.to')}}",
           });
}
        

          
       })
   }
   initMap();
</script>


{{-- <script>
    function initMap() {

    var $maps = $('.map');

$.each($maps, function (i, value) {

    var // pointA = new google.maps.LatLng(parseFloat($(value).attr('lat')),  parseFloat($(value).attr('lng'))),
        pointB = new google.maps.LatLng(parseFloat($(value).attr('lat2')), parseFloat($(value).attr('lng2'))),
          myOptions = {
         zoom: 7,
         center: pointB
        },
        mapDivId = $(value).attr('id'),
        map = new google.maps.Map(document.getElementById(mapDivId), myOptions),
        // Instantiate a directions service.
        directionsService = new google.maps.DirectionsService,
        directionsDisplay = new google.maps.DirectionsRenderer({
        map: map
        }),
        // markerA = new google.maps.Marker({
        // position: pointA,
        // title: "point A",
        // label: "A",
        // map: map
        // }),
        markerB = new google.maps.Marker({
        position: pointB,
        title: "point B",
        label: "B",
        map: map
        });

    // get route from A to B
    //calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);

    });
}


// not working 
// function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
//   directionsService.route({
//     origin: pointA,
//     destination: pointB,
//     travelMode: google.maps.TravelMode.DRIVING
//   }, function(response, status) {
//     if (status == google.maps.DirectionsStatus.OK) {
//       directionsDisplay.setDirections(response);
//     } else {
//       window.alert('Directions request failed due to ' + status);
//     }
//   });
// }

initMap();
</script> --}}