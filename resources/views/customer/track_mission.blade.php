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
	<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
    <script type="text/javascript">
	// agentMap
	var markers = [
            {
                "title": 'you',
                "lat": "{{$mission->latitude}}",
                "lng": "{{$mission->longitude}}",
                "description": 'Alibaug is a coastal town and a municipal council in Raigad District in the Konkan region of Maharashtra, India.'
            },
            {
                "title": "{{$mission->agent->username}}",
                "lat": "{{$mission->agent->current_latitude}}",
                "lng": "{{$mission->agent->current_longitude}}",
                "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
            }
    ];
    window.onload = function () {
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("agentMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();
        for (i = 0; i < markers.length; i++) {
            var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: data.title
            });
            latlngbounds.extend(marker.position);
            (function (marker, data) {
                // google.maps.event.addListener(marker, "click", function (e) {
                    // infoWindow.setContent(data.description);
                    // infoWindow.open(map, marker);
                // });
            })(marker, data);
        }
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
        //Initialize the Path Array
        var path = new google.maps.MVCArray();
        //Initialize the Direction Service
        var service = new google.maps.DirectionsService();
 
        //Set the Path Stroke Color
        var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
 
        //Loop and Draw Path Route between the Points on MAP
        for (var i = 0; i < lat_lng.length; i++) {
            if ((i + 1) < lat_lng.length) {
                var src = lat_lng[i];
                var des = lat_lng[i + 1];
                path.push(src);
                poly.setPath(path);
                service.route({
                    origin: src,
                    destination: des,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                            path.push(result.routes[0].overview_path[i]);
                        }
                    }
                });
            }
        }
    }
    </script>
	<script src="https://maps.googleapis.com/maps/api/js?key={{ Helper::google_api_key() }}&libraries=places&callback=initMap"
        async defer></script>
@endsection