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
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ Helper::google_api_key() }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Helper::google_api_key() }}&libraries=places&callback=initAutocomplete"
        async defer></script>
	<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
    <script type="text/javascript">
	let socket = io.connect("{{ Helper::api_url() }}");
    var username = "{{$mission->agent->username}}";
	var mission_id = {{$mission_id}};
    var zoomVal = 22;
	// document.getElementById("agentMap")
    var map,
        markArray = [];
    function initMap() {
	  const myLatlng = { lat: -25.363, lng: 131.044 };
	  const map = new google.maps.Map(document.getElementById("agentMap"), {
		zoom: 4,
		center: myLatlng,
	  });
	  const marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: "Click to zoom",
	  });
	  map.addListener("center_changed", () => {
		// 3 seconds after the center of the map has changed, pan back to the
		// marker.
		window.setTimeout(() => {
		  map.panTo(marker.getPosition());
		}, 3000);
	  });
	  marker.addListener("click", () => {
		// map.setZoom(8);
		// map.setCenter(marker.getPosition());
		newLocation = new google.maps.LatLng('30.401071024414478','76.74540037318917');
		marker.setPosition( newLocation );
	  });
	}
    window.onload = function(){
		// initMap(zoomVal,'30.401071024414478','76.74540037318917',username);
		initMap();
	}
	
    </script>
@endsection