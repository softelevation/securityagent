@extends('layouts.dashboard')
@section('content')
<div class="agent_Map">
        <div class="row">
            @include('includes.customer_sidebar')
            <div class="col-md-9">
                <div class="map_Agent">
                    <div id="agentMap" class="map_div" style="height: 650px;"></div>
                    <div class="map_cont">
                        <div class="row">   
                            <div class="col-md-6">
                                <div class="agent_icon_panel">
                                    <img src="{{asset('assets/images/agent_icon.png')}}"/>
                                    <!-- <h4>Agent Icon</h4> -->

                                    <!-- <p>Agents Near Your Search Area</p> -->
                                </div>
                                <div class="legend_icons">
                                    <div class="pb-1">
                                        <img src="{{asset('avatars/marker-male.png')}}"/> 
                                        <span>{{__('frontend.text_44')}}</span>
                                    </div>
                                    <div>
                                        <img src="{{asset('avatars/marker-female.png')}}"/> 
                                        <span>{{__('frontend.text_45')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>{{__('frontend.text_46')}}</h6>
                                <div class="slidecontainer">
                                  <input type="range" min="1" max="100" value="70" class="slider" id="mapZommRange">
                                </div>
                                <div class="km"><span id="km"></span> km</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?key={{ Helper::google_api_key() }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Helper::google_api_key() }}&libraries=places&callback=initAutocomplete"
        async defer></script>
	<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
    <script type="text/javascript">
	let socket = io.connect("{{ Helper::api_url() }}");
	// var search = '@php echo $mission_id; @endphp';
    // var zoomVal = parseInt('@php echo $mission_id; @endphp');
	
    // var latitude = '48.8796835';
    var username = "{{$mission->agent->username}}";
	var mission_id = {{$mission_id}};
    var zoomVal = 22;
    var map,
        markArray = [];
    function initMap(zoomVal,lat,longs,username) {
        var mapOptions = {
            center: new google.maps.LatLng(lat, longs),
            zoom: zoomVal,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };    
        map = new google.maps.Map(document.getElementById("agentMap"), mapOptions);
		let marker_s = 'https://beontime.io/avatars/marker-male.png';
        addMarkers(lat,longs,username,marker_s);
    }

    function addMarkers(lat,longs,username,marker_s) {
        var infowindow = new google.maps.InfoWindow();
        var bounds = new google.maps.LatLngBounds();
        var marker, i;
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, longs),
            map: map,
            icon: marker_s,
          });
          bounds.extend(marker.position);
          google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
              var contentString = username;
              infowindow.setContent(contentString);
              infowindow.open(map, marker);
            }
          })(marker, i));
          markArray.push(marker);
    }
    // window.onload = function(){
		// addMarkers(lat,longs,username,marker_s);
	initMap(zoomVal,'30.393908','76.768404',username);
	socket.on('agent_location_'+mission_id,function(msg){
		console.log(msg);
		if(msg){
			initMap(zoomVal, msg.latitude,msg.longitude,username); 
		}
		// initMap(zoomVal, msg.latitude,msg.longitude); 
	});
	
    </script>
@endsection