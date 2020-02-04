@extends('layouts.app')
@section('content')
    <div class="location_search">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="location_btn">
                        <form id="search_filter_form" method="get" action="{{url('/available-agents')}}">
                            <div class="locationSearch">
                                <input id="autocomplete1" name="location" placeholder="Enter your location" class="form-control"  onFocus="geolocate('autocomplete1')" type="text"/>
                                <span><i class="fa fa-paper-plane"></i></span>
                            </div>
                        <input type="hidden" id="latitude1" name="latitude" value="@if(isset($search['latitude'])) {{$search['latitude']}} @endif" />
                        <input type="hidden" id="longitude1" name="longitude" value="@if(isset($search['longitude'])) {{$search['longitude']}} @endif" />
                        <input id="search_type" type="hidden" name="type">
                        <input id="search_val" type="hidden" name="value">
                        <button class="yellow_btn">Search Now</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="location_btn float-left w-50">
                        <button  data-toggle="modal" data-target="#create_mission_model" class="orange_btn d-block">Book An Agent Now</button>
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
                                    @if(Session::has('mission'))<p class="pt-2"><a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" class="btn_submit bookAgentBtn">Book Now</a></p>@endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="agent_review">
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                        <h5>Agent at Home <span>A Agent of USA</span></h5>
                                        @if(Session::has('mission'))<a target="_blank" href="{{url('/agent-details/'.Helper::encrypt($agent->id))}}" class="text-link">View Agent Details</a>@endif
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

    <!-- Create Mission Model -->
    <div id="create_mission_model" class="modal fade" role="dialog">
      <div class="modal-dialog modal-md w-50" style="max-width: 650px;">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">        
            <h4 class="modal-title">Find an agent for a mission</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12"> 
                    {{Form::open(['url'=>url('save-mission-temporary'),'id'=>'general_form_2'])}}
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>Mission Title</label>
                          {{Form::text('title',null,['class'=>'form-control','placeholder'=>'Enter mission title'])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Mission Location</label>
                          {{Form::text('location',null,['id'=>'autocomplete2', 'placeholder'=>'Enter your location', 'class'=>'form-control',  'onFocus'=>'geolocate("autocomplete2")'])}}
                          <!--Work Location Lat Longs  -->
                          {{Form::hidden('latitude',null,['id'=>'latitude2'])}}
                          {{Form::hidden('longitude',null,['id'=>'longitude2'])}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>Agent Type</label>
                          @php $agentTypes = Helper::get_agent_type_list(); @endphp
                          {{Form::select('agent_type',$agentTypes,null,['class'=>'form-control'])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Hours Required</label>
                          @for($i=1; $i<=24; $i++)
                            @php 
                              if($i==1){
                                $hours[$i] = $i.' Hour';  
                              }else{
                                $hours[$i] = $i.' Hours';
                              }
                            @endphp
                          @endfor
                          {{Form::select('total_hours',$hours,null,['class'=>'form-control'])}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 form-group">
                          <label>Mission Description</label>
                          {{Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Enter mission description'])}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="quick_book" value="1">
                            <button type="submit" class="button success_btn">Find An Agent Now</button>
                        </div>
                      </div>
                    {{Form::close()}}
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{Form::open(['id'=>'general_form','url'=>url('book-agent')])}}
    {{Form::hidden('agent_id',null,['id'=>'bookingAgentId'])}}
    {{Form::close()}}
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

        // Book an agent
        $(document).on('click','.bookAgentBtn',function(){
            let id = $(this).attr('id');
            $('#bookingAgentId').val(id);
            $('#general_form').submit();
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

    function initAutocomplete(selecter='autocomplete1') {    
        autocomplete = new google.maps.places.Autocomplete(document.getElementById(selecter), {types: ['geocode']});
        if(selecter=='autocomplete1'){ autocomplete.addListener('place_changed', fillInAddress1); }
        if(selecter=='autocomplete2'){ autocomplete.addListener('place_changed', fillInAddress2); }
    }

    function fillInAddress1() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      var search_location_lat = document.querySelector("input[id='latitude1']");
      var search_location_long = document.querySelector("input[id='longitude1']");
      search_location_lat.value = place.geometry.location.lat(); 
      search_location_long.value = place.geometry.location.lng(); 
    }

    function fillInAddress2() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      var search_location_lat = document.querySelector("input[id='latitude2']");
      var search_location_long = document.querySelector("input[id='longitude2']");
      search_location_lat.value = place.geometry.location.lat(); 
      search_location_long.value = place.geometry.location.lng(); 
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate(selecter) {
        initAutocomplete(selecter);
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