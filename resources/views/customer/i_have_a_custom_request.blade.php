@extends('layouts.dashboard')
@section('content')
<style>
.disable{
	pointer-events:none;
	background:#e9ecef;
}
.custom-mission-request{background-color: #fbda51 !important;}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.i_have_mission_requests')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3 class="custom-mission-request"><i class="fa fa-edit"></i> {{__('dashboard.mission.create_new_mission_req')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    @if(isset($mission))
                      {{Form::model($mission,['id'=>'general_form','url'=>url('customer/mission-request')])}}
                      {{Form::hidden('record_id',Helper::encrypt($mission->id))}}
                    @else
                      {{Form::open(['id'=>'general_form','url'=>url('customer/mission-request')])}}
                    @endif
					  
                      <div class="row custom-mission-request">
						  <div class="col-md-12">
						  <label class="custom-mission-request text-uppercase">{{__('frontend.mission_request.general_infos')}}</label>
						  </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('frontend.mission_request.request_title_object')}}</label> 
                          {{Form::text('general_info',null,['class'=>'form-control','placeholder'=>__('frontend.mission_request.request_title_object')])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('frontend.mission_request.request_location')}}</label>
                          {{Form::text('request_location',null,['id'=>'autocomplete', 'placeholder'=>__('frontend.mission_request.request_location'), 'class'=>'form-control',  'onFocus'=>'geolocate()'])}}
                          <!--Work Location Lat Longs  -->
                          {{Form::hidden('latitude')}}
                          {{Form::hidden('longitude')}}
                        </div>
						<div class="col-md-12 form-group">
                          <label>{{__('frontend.mission_request.request_description')}}</label>
                          {{Form::textarea('description',null,['class'=>'form-control','placeholder'=>__('frontend.mission_request.request_description_place')])}}
                        </div>
					</div>	<br/>
					<label class="text-uppercase">{{__('frontend.mission_request.detail_info_maindatory')}}</label><br/>
					<label>{{__('frontend.mission_request.if_you_can_specify')}}</label>
					<div class="row">
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.agents.type')}}</label>
                          <select name="agent_type" class="form-control">
								<option value="">{{__('frontend.select')}}</option>
								@foreach(Helper::get_agent_type_list() as $key => $agent_list)
									<option value="{{$agent_list}}">{{$agent_list}}</option>
								@endforeach
						  </select>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.mission.hours_req')}}</label>
                          @php $hours[] = __('dashboard.mission.dont_know_hours') @endphp  
                          @for($i=1; $i<=72; $i++)
                            @php 
                              if($i==1){
                                $hours[$i] = $i.' '.__('dashboard.hr');  
                              }else{
                                $hours[$i] = $i.' '.__('dashboard.hrs');
                              }
                            @endphp
                          @endfor
                          {{Form::select('total_hours',$hours,null,['class'=>'form-control mission_hours'])}}
                        </div>
						<div class="col-md-6 form-group">
                            <label>{{__('frontend.mission_request.how_many_agents')}}</label>
                            {{Form::text('agent_count',null,['class'=>'form-control','placeholder'=>__('frontend.mission_request.how_many_agents')])}}
                        </div>
                        <div id="misionStartEndDiv" class="col-md-6 form-group">
                            <label>{{__('frontend.mission_request.mission_date')}}</label>
                            {{Form::text('start_date_time',null,['class'=>'form-control datetimepicker','placeholder'=>__('frontend.mission_request.mission_date')])}}
                        </div>
						<div class="col-md-6 form-group">
                          <label>{{__('dashboard.mission.from_when_start')}}</label><br>
                          <label class="rd_container form-inline">{{__('dashboard.now')}}
                            {{Form::radio('quick_book',1,false,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">{{__('dashboard.mission.later')}}
                            {{Form::radio('quick_book',0,true,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div class="col-md-6 form-group create-new-mission">
                          <label>{{__('dashboard.mission.agent_vehicle')}}</label><br>
                          <label class="rd_container form-inline">{{__('dashboard.yes')}}
                            {{Form::radio('vehicle_required',1,false)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">{{__('dashboard.no')}}
                            {{Form::radio('vehicle_required',2,false)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">{{__('dashboard.mission.not_matter')}}
                            {{Form::radio('vehicle_required',3,true)}}
                            <span class="checkmark"></span>
                          </label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="button success_btn">{{__('dashboard.mission.book_mission_request')}}</button>
                        </div>
                      </div>
                    {{Form::close()}}
                </div>
              </div>
            </div>
          </div>
            <!-- /.col-md-8 -->
        </div>
    </div>
    <!-- /.container -->
</div>

<script>
  $(document).ready(function(){
    $(document).on('click','.confirmBtn',function(){
      $(document).find('#general_form').submit();
      $(document).find("#conform_action").modal("hide");
    });
  });
</script>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ Helper::google_api_key() }}&libraries=places&callback=initAutocomplete"
    async defer></script>
@endsection