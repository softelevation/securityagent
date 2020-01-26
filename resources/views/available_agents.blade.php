@extends('layouts.app')
@section('content')
    <div class="location_search">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="location_btn">
                        <form id="search_filter_form" method="get" action="{{url('/available-agents')}}">
                            <div class="locationSearch">
                                <input id="autocomplete" name="location" placeholder="Enter your location" class="form-control"  onFocus="geolocate()" type="text"/>
                                <span><i class="fa fa-paper-plane"></i></span>
                            </div>
                        <input type="hidden" name="latitude" value="@if(isset($search['latitude'])) {{$search['latitude']}} @endif" />
                        <input type="hidden" name="longitude" value="@if(isset($search['longitude'])) {{$search['longitude']}} @endif" />
                        <input id="search_type" type="hidden" name="type">
                        <input id="search_val" type="hidden" name="value">
                        <button class="yellow_btn">Search Now</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="location_btn float-left w-50">
                        <button class="orange_btn d-block">Book An Agent Now</button>
                    </div>
                    <div class="float-right">
                        <ul class="dropdown filter-wrap">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle filterSearch" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter Agents By</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" style="border:none;" href="#">Agent Type</a>
                                        <ul class="dropdown-menu agent_types">
                                            <li class="search_filter" data-type="agent_type" id="1"><a href="javascript:void(0)">Agent SSIAP 1</a></li>
                                            <li class="search_filter" data-type="agent_type" id="2"><a href="javascript:void(0)">Agent SSIAP 2</a></li>
                                            <li class="search_filter" data-type="agent_type" id="3"><a href="javascript:void(0)">Agent SSIAP 3</a></li>
                                            <li class="search_filter" data-type="agent_type" id="4"><a href="javascript:void(0)">ADS With Vehicule or Not</a></li>
                                            <li class="search_filter" data-type="agent_type" id="5"><a href="javascript:void(0)">Body Guard Without Weapon</a></li>
                                            <li class="search_filter" data-type="agent_type" id="6"><a href="javascript:void(0)">Dog Handler</a></li>
                                            <li class="search_filter" data-type="agent_type" id="7"><a href="javascript:void(0)">Hostesses</a></li>
                                        </ul>
                                    </li>
                                  <li class="search_filter" data-type="is_vehicle" id="1"><a class="dropdown-item" href="javascript:void(0)">Agent With Veichle</a></li>
                                  <li class="search_filter" data-type="is_vehicle" id="0"><a class="dropdown-item" href="javascript:void(0)">Agent Without Veichle</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="agent_Map">
        <div class="row">
            <div class="col-md-4 padding_right_0">
                <div class="Agent_list">
                    <h3>Agent In {{$search['location']}} <span>How to choose ?</span></h3>
                    @php $i = 0; @endphp
                    @forelse(json_decode($data) as $agent)
                    @php $i++; @endphp
                    <div class="list_box agent_detail_{{$i}} agent_list_div">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="agent_img">
                                    <img src="{{$agent->avatar_icon}}"/>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="agent_cont">
                                    <h4>{{$agent->username}}</h4>
                                    <p>{{Helper::get_agent_type_name_multiple($agent->types)}}</p>
                                    <p>@if($agent->is_vehicle==1) With Vehicle @else Without Vehicle @endif</p>
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
                    <div class="text-center no_avail_agent_message pt-3 d-none">
                        <i>No agent available at the moment on this locaion.</i>
                    </div>
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


        $(document).on('click','.search_filter', function(){
            let type = $(this).attr('data-type');
            let value = $(this).attr('id');
            $(document).find('#search_type').val(type);
            $(document).find('#search_val').val(value);
            $(document).find('#search_filter_form').trigger('submit');
        });
    </script>
    
    <script type="text/javascript">
    function getAvailableAgents(){
        var count = $(document).find('.agent_list_div').length;
        if(count > 0){
            $(document).find('.no_avail_agent_message').addClass('d-none');
        }else{
            $(document).find('.no_avail_agent_message').removeClass('d-none');
        }
    }
    var latitude = '@php echo $search["latitude"]; @endphp';
    var longitude = '@php echo $search["longitude"]; @endphp';
    var map,
        markArray = [];
    function initMap(radius) {
        var mapOptions = {
            center: new google.maps.LatLng(latitude, longitude),
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
            position: new google.maps.LatLng(locations[i].lat, locations[i].long),
            map: map,
          });
          bounds.extend(marker.position);
          google.maps.event.addListener(marker, 'tilesloaded', (function(marker, i) {
            return function() {
              var contentString = locations[i].username;
              infowindow.setContent(contentString);
              infowindow.open(map, marker);
            }
          })(marker, i));
          markArray.push(marker);
        }
    }

    function setRadius(radius){
        var circleOptions = {
            center: new google.maps.LatLng(latitude, longitude),
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
            var agent_details = '.agent_detail_'+(i+1);
            if(inMap===true) {
                $(document).find(agent_details).show().addClass('agent_list_div');
                count++;
            }else{
                $(document).find(agent_details).hide().removeClass('agent_list_div');
            }
        }
        getAvailableAgents();
        // console.log(count);
    }
    window.onload = function(){ initMap(10000); };
    </script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA"></script>

    <!-- Google Places API -->
    <script>
    var placeSearch, autocomplete;

    function initAutocomplete() {
      // Create the autocomplete object, restricting the search predictions to
      // geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
          document.getElementById('autocomplete'), {types: ['geocode']});

      // Avoid paying for data that you don't need by restricting the set of
      // place fields that are returned to just the address components.
      // autocomplete.setFields(['address_component']);

      // When the user selects an address from the drop-down, populate the
      // address fields in the form.
      autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      var search_location_lat = document.querySelector("input[name='latitude']");
      var search_location_long = document.querySelector("input[name='longitude']");
      search_location_lat.value = place.geometry.location.lat(); 
      search_location_long.value = place.geometry.location.lng(); 
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var circle = new google.maps.Circle(
              {center: geolocation, radius: position.coords.accuracy});
          autocomplete.setBounds(circle.getBounds());
        });
      }
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA&libraries=places&callback=initAutocomplete"
        async defer></script>
@endsection