<script>
  var maps = [];

   var markers = [];

   function initMap() {

       var $maps = $('.map');

       $.each($maps, function (i, value) {
        var LatLng = $(value).attr('latlng');
        var Lng = $(value).attr('lng');
        var Lat = $(value).attr('lat');
      
        var mapDivId = $(value).attr('id');

        var map = new google.maps.Map(document.getElementById(mapDivId), {
          center: new google.maps.LatLng(Lat,Lng),
          zoom: 12
        });
       
          new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(Lat,Lng),
         // draggable : true,
          title: "source",
          
           });
        

          
       })
   }
  // initMap();
</script>


<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVFiE8-BpyH5SbzDRvamysRcf2TkWzQfU&callback=initMap">
</script>