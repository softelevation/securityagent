@extends('layouts.app')
@section('content')
    <div class="location_search">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="location_btn">
                        <div class="locationSearch">
                            <input type="search" class="form-control" placeholder="Type location here">
                            <span><i class="fa fa-paper-plane"></i></span>
                        </div>
                        <a href="#" class="yellow_btn">Search Now</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dropdown">
                      <span class="filterSearch dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Search by Filter</span>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="agent_Map">
        <div class="row">
            <div class="col-md-4 padding_right_0">
                <div class="Agent_list">
                    <h3>Agent In USA <span>How to choose ?</span></h3>
                    @forelse(json_decode($data) as $agent)
                    <div class="list_box">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="agent_img">
                                    <img src="{{$agent[1]}}"/>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="agent_cont">
                                    <h4>{{$agent[0]}}</h4>
                                    <p>Lorum Ipsum</p>
                                    <!-- <p>Déjà mère de grands enfants, femme d'expérience (7 années de service) résidant à Paris 3ème. </p> -->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="agent_review">
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                        <h5>Agent at Home <span>A Agent of USA</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="col-md-8 padding_0">
                <div class="map_Agent">
                    <div id="agentMap" class="map_div" style="height: 500px;"></div>
                    <div class="map_cont">
                        <div class="row">   
                            <div class="col-md-6">
                                <div class="agent_icon_panel">
                                    <img src="{{asset('assets/images/agent_icon.png')}}"/>
                                    <h4>Agent Icon</h4>
                                    <p>Agents Near Your Search Area</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Research radius</h6>
                                <div class="slidecontainer">
                                  <input type="range" min="1" max="100" value="10" class="slider" id="mapZommRange">
                                </div>
                                <div class="km"><span id="km"></span> km</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var slider = document.getElementById("mapZommRange");
        var output = document.getElementById("km");
        output.innerHTML = slider.value; // Display the default slider value
        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function() {
            output.innerHTML = this.value;
        }
        $(document).on('mouseup','#mapZommRange',function(){
            var radius = $(this).val();
            radius = parseInt(radius);
            radius = radius*1000;
            setTimeout(function(){ initMap(radius); }, 500);
        });
    </script>
    
    <script type="text/javascript">
    var map,
        markArray = [];
    function initMap(radius) {
        var mapOptions = {
            center: new google.maps.LatLng(48.8566, 2.3522),
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };    
        map = new google.maps.Map(document.getElementById("agentMap"), mapOptions);
        // Adding our markers from our "big database"
        addMarkers();
        setRadius(radius);
        // Fired when the map becomes idle after panning or zooming.
        google.maps.event.addListener(map, 'idle', function() {
            showVisibleMarkers();
        });
    }

    function addMarkers() {
        var locations = JSON.parse('@php echo $data @endphp');
        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][3], locations[i][4]),
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
            center: new google.maps.LatLng(48.8566, 2.3522),
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
@endsection