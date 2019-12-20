<style type="text/css">
  #map-canvas {
    width:450px;
    height:340px;
}

#infos {
    position:absolute;
    top:60px;
    left:470px;
    width:300px;
}

#infos .info {
    background-color:#eee;
    padding:15px 25px;
    margin:10px 0;
}

p { 
    width:450px;
}

</style>
<h1>Google Maps - Visible Markers In Bounds</h1>

<div id="map-canvas"></div>

<div id="infos">
    <h2><span></span> visible beaches</h2>
    <div class="info info-1">Bondi Beach</div>
    <div class="info info-2">Coogee Beach</div>
    <div class="info info-3">Cronulla Beach</div>
  <div class="info info-4">Manly Beach</div>
  <div class="info info-5">Maroubra Beach</div>
</div>

<p>Try to zoom in/out.<br />Infos panels will be shown/hidden if markers visible on map.</p>

<script>

    var map,
        markArray = [];
        var locations = [
            ['Bondi Beach', -33.890542, 151.274856],
            ['Coogee Beach', -33.923036, 151.259052],
            ['Cronulla Beach', -34.028249, 151.157507],
            ['Manly Beach', -33.80010128657071, 151.28747820854187],
            ['Maroubra Beach', -33.950198, 151.259302]
        ];
    function initMap(radius) {
        var mapOptions = {
            center: new google.maps.LatLng(-33.9, 151.2),
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };    
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        // Adding our markers from our "big database"
        addMarkers();
        setRadius(radius);
        // Fired when the map becomes idle after panning or zooming.
        google.maps.event.addListener(map, 'idle', function() {
            showVisibleMarkers();
        });
    }

    function addMarkers() {
        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
          });
          bounds.extend(marker.position);
          google.maps.event.addListener(marker, 'tilesloaded', (function(marker, i) {
            return function() {
              var contentString = locations[i][0];
              infowindow.setContent(contentString);
              infowindow.open(map, marker);
            }
          })(marker, i));
          markArray.push(marker);
        }
    }

    function setRadius(radius){
        var circleOptions = {
            center: new google.maps.LatLng(-33.9, 151.2),
            fillOpacity: 0,
            strokeOpacity:0,
            map: map,
            radius: radius 
        }
        var myCircle = new google.maps.Circle(circleOptions);
        map.fitBounds(myCircle.getBounds());
    }

    function showVisibleMarkers() {
        var bounds = map.getBounds(),
        count = 0;
        for (var i = 0; i < markArray.length; i++) {
            var marker = markArray[i];
            var inMap = bounds.contains(marker.getPosition());
            if(inMap===true) {
                count++;
            }
        }
        console.log(count);
    }
    window.onload = function(){ initMap(10000); };
    </script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA"></script>