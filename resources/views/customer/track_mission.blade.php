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
	// Initialize and add the map
var map;
function initMap() {
  // The map, centered on Central Park
  const center = {lat: 40.774102, lng: -73.971734};
  const options = {zoom: 15, scaleControl: true, center: center};
  map = new google.maps.Map(
      document.getElementById('agentMap'), options);
  // Locations of landmarks
  const dakota = {lat: 40.7767644, lng: -73.9761399};
  const frick = {lat: 40.771209, lng: -73.9673991};
  // The markers for The Dakota and The Frick Collection
  var mk1 = new google.maps.Marker({position: dakota, map: map});
  var mk2 = new google.maps.Marker({position: frick, map: map});
}
    </script>
@endsection