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
                        <input id="is_vehicle_field" type="hidden" name="is_vehicle">
                        <input id="agent_type_field" type="hidden" name="agent_type">
                        <button class="yellow_btn">Search Now</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="location_btn d-inline-block">
                                <button @if(Auth::check() && Auth::user()->role_id==1) data-toggle="modal" data-target="#create_mission_model" @else data-msg-type="error" data-msg="Please login or signup before booking an agent." @endif class="@if(!(Auth::check() && Auth::user()->role_id==1)) alert-msg @endif orange_btn d-block">Book An Agent Now</button>
                            </div> -->
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
                                            <li class="search_filter" data-type="agent_type" id="4"><a href="javascript:void(0)">ADS</a></li>
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
                    <h3>{{__('frontend.text_2')}} {{$search['location']}}</h3> 
                    <div class="mt-2 mb-2">
                        <div class="float-left pt-2">
                                <span data-container="body" data-toggle="popover" data-placement="left" data-content="Click on <b>Book An Agent Now</b> button and fill your mission details. After submit, choose an agent and click on <b>Book Now </b> button." data-html="true" data-trigger="hover">How to book an agent <i class="fa fa-question-circle"></i></span>
                        </div>
                        @if(Session::has('mission'))
                        <div class="float-right">
                            <button class="btn_submit" data-toggle="modal" data-target="#create_mission_model">CHANGE MISSION DETAILS</button>
                        </div>
                        @endif
                        <div class="clearfix"></div> 
                    </div>
                    @php $i = 0; @endphp
                    @if(Auth::check() && Auth::user()->role_id==1 && Session::has('mission'))
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
                                            @if(Session::has('mission'))<p class="pt-2"><a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" data-distance="{{$agent->distance}}" class="btn_submit bookAgentBtn">Book Now</a></p>@endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="agent_review">
                                            <div class="star">
                                                <img src="{{asset('assets/images/star.jpg')}}"/>
                                                <h5>Agent at Home <br><span>An Agent of USA</span></h5>
                                                @if(Session::has('mission'))<a target="_blank" href="{{url('/agent-details/'.Helper::encrypt($agent->id))}}" class="text-link">View Agent Details</a>@endif<br>
                                                <span>{{$agent->distance}} Km away</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center no_avail_agent_message pt-3 d-none">
                                <i>No agent available at the moment on this location. </i>
                            </div>
                        @empty
                            <div class="text-center no_avail_agent_message pt-3 d-none">
                                <i>No agent available at the moment on this location. </i>
                            </div>
                        @endforelse
                    @else
                        <div class="card text-center card_section" style="width: 96%;">
                          <div class="card-body">
                            <!-- <h5 class="card-title">Book An Agent Now</h5> -->
                            <p class="card-text">Click on <b>Book An Agent Now</b> button and fill your mission details. After submit, choose an agent and click on <b>Book Now </b> button.</p>
                            <div class="location_btn d-inline-block">
                                <button @if(Auth::check() && Auth::user()->role_id==1) data-toggle="modal" data-target="#create_mission_model" @else data-msg-type="error" data-msg="Please login or signup before booking an agent." @endif class="@if(!(Auth::check() && Auth::user()->role_id==1)) alert-msg @endif orange_btn d-block">Book An Agent Now</button>
                            </div>
                          </div>
                        </div>
                    @endif
                    
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
                                    <!-- <h4>Agent Icon</h4> -->

                                    <!-- <p>Agents Near Your Search Area</p> -->
                                </div>
                                <div class="legend_icons">
                                    <div class="pb-1">
                                        <img src="{{asset('avatars/marker-male.png')}}"/> 
                                        <span>Security agent icon</span>
                                    </div>
                                    <div>
                                        <img src="{{asset('avatars/marker-female.png')}}"/> 
                                        <span>Hostess agent icon</span>
                                    </div>
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
            <h4 class="modal-title">Book an agent for a mission</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12"> 
                    @if(Session::has('mission'))
                        @php $tempMission = Session::get('mission'); @endphp
                        {{Form::model($tempMission,['url'=>url('save-mission-temporary'), 'id'=>'general_form_2', 'autocomplete'=>'off'])}}
                    @else
                        {{Form::open(['url'=>url('save-mission-temporary'), 'id'=>'general_form_2', 'autocomplete'=>'off'])}}
                    @endif
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
                        <div class="col-md-6 form-group">
                          <label>Agent Type</label>
                          @php $agentTypes = Helper::get_agent_type_list(); @endphp
                          {{Form::select('agent_type',$agentTypes,null,['class'=>'form-control'])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Hours Required</label>
                          @php $hours[] = "Don't know how many hours needed"; @endphp
                          @for($i=1; $i<=72; $i++)
                            @php 
                              if($i==1){
                                $hours[$i] = $i.' Hour';  
                              }else{
                                $hours[$i] = $i.' Hours';
                              }
                            @endphp
                          @endfor
                          {{Form::select('total_hours',$hours,null,['class'=>'form-control mission_hours'])}}
                          <span class="mission_hours_note @if(isset($tempMission['total_hours'])) d-none @endif">Note: You will be charged for 8 Hours, if you don't know how many hours needed.</span>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>From When You Want To Start The Mission?</label>
                          <label class="rd_container form-inline">Now
                            {{Form::radio('quick_book',1,true,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">Later
                            {{Form::radio('quick_book',0,false,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div id="misionStartEndDiv" class="col-md-6 form-group d-none">
                            <label>Mission Start Date Time</label>
                            <input class="form-control datetimepicker" placeholder="Date Time" name="start_date_time" type="text">
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Do you prefer an agent having a vehicle?</label><br>
                          <label class="rd_container form-inline">Yes
                            {{Form::radio('vehicle_required',1,false)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">No
                            {{Form::radio('vehicle_required',2,true)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">Doesn't Matter
                            {{Form::radio('vehicle_required',3,true)}}
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Mission Description</label>
                          {{Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Enter mission description'])}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
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
    {{Form::hidden('distance',null,['id'=>'bookingAgentDistance'])}}
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
            if(type=='agent_type'){
                $(document).find('#agent_type_field').val(value);
            }
            if(type=='is_vehicle'){
                $(document).find('#is_vehicle_field').val(value);
            }
            $(document).find('#search_filter_form').trigger('submit');
        });

        // Book an agent
        $(document).on('click','.bookAgentBtn',function(){
            let id = $(this).attr('id');
            let distance = $(this).attr('data-distance')
            $('#bookingAgentId').val(id);
            $('#bookingAgentDistance').val(distance);
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
    var search = '@php echo $search["s_val"]; @endphp';
    var zoomVal = parseInt('@php echo $search["zoom"]; @endphp');
    var map,
        markArray = [];
    function initMap(radius) {
        var mapOptions = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: zoomVal,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };    
        map = new google.maps.Map(document.getElementById("agentMap"), mapOptions);
        // Adding our markers from our "big database"
        addMarkers();
        // if(search==true){
        //     setRadius(radius);
        // }
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
            icon: locations[i].marker,
          });
          bounds.extend(marker.position);
          google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
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
