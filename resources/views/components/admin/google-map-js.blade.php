<script>
  var dlat = {{ !empty($lat) ? $lat : 24.720012952625147 }};
    var dlng = {{ !empty($lng) ? $lng : 46.67266803125 }};



    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(dlat, dlng),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

        var marker = new google.maps.Marker({
          map: map,
          position: { lat: dlat , lng : dlng},
          draggable : true,
          // label: icon.label
        });
        marker.addListener('click', function() {
          infoWindow.setContent(infowincontent);
          infoWindow.open(map, marker);
        });

        google.maps.event.addListener(marker,'position_changed', function() {
          var lat = marker.getPosition().lat();
          var lng = marker.getPosition().lng();
          document.getElementById("lat").value=lat;
          document.getElementById("lng").value=lng;
        });

    }



  // function downloadUrl(url, callback) {
  //   var request = window.ActiveXObject ?
  //       new ActiveXObject('Microsoft.XMLHTTP') :
  //       new XMLHttpRequest;
  //
  //   request.onreadystatechange = function() {
  //     if (request.readyState == 4) {
  //       request.onreadystatechange = doNothing;
  //       callback(request, request.status);
  //     }
  //   };
  //
  //   request.open('GET', url, true);
  //   request.send(null);
  // }

  function doNothing() {}
</script>


<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVFiE8-BpyH5SbzDRvamysRcf2TkWzQfU&callback=initMap">
</script>