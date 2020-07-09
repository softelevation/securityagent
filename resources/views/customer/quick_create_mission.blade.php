@extends('layouts.dashboard')
@section('content')
<style>
.disable{
	pointer-events:none;
	background:#e9ecef;
}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.missions')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> {{__('dashboard.mission.create_new')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    @if(isset($mission))
                      {{Form::model($mission,['id'=>'general_form','url'=>url('save-mission-temporary')])}}
                      {{Form::hidden('record_id',Helper::encrypt($mission->id))}}
                    @else
                      {{Form::open(['id'=>'general_form','url'=>url('save-mission-temporary')])}}
                    @endif
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.mission.title')}}</label> 
                          {{Form::text('title',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.title_place')])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.mission.location')}}</label>
                          {{Form::text('location',null,['id'=>'autocomplete', 'placeholder'=>__('dashboard.mission.location_place'), 'class'=>'form-control',  'onFocus'=>'geolocate()'])}}
                          <!--Work Location Lat Longs  -->
                          {{Form::hidden('latitude')}}
                          {{Form::hidden('longitude')}}
                        </div>
						<div class="col-md-12 form-group">
                          <label>{{__('dashboard.agents.intervention')}}</label>
						  <select class="form-control intervention" name="intervention" aria-invalid="false">
							<option value="Guard_service" @if(isset($mission) && !empty($mission->intervention) && $mission->intervention == 'Guard_service') selected @endif>{{__('dashboard.agents.Guard_service')}}</option>
							<option value="Intervention" @if(isset($mission) && !empty($mission->intervention) && $mission->intervention == 'Intervention') selected @endif>{{__('dashboard.agents.Intervention')}}</option>
							<option value="Security_patrol" @if(isset($mission) && !empty($mission->intervention) && $mission->intervention == 'Security_patrol') selected @endif data-available_to_place="{{__('dashboard.agents.available_to_place')}}" data-finish_time="{{__('dashboard.agents.finish_time')}}" data-repetitive_mission="{{__('dashboard.agents.repetitive_mission')}}" data-time_intervel="{{__('dashboard.agents.time_intervel')}}" data-hrs="{{__('dashboard.hrs')}}" data-hr="{{__('dashboard.hr')}}" data-select="{{__('frontend.select')}}" data-same_day="{{__('dashboard.agents.same_day')}}" data-week="{{__('dashboard.agents.week')}}">{{__('dashboard.agents.Security_patrol')}}</option>
						  </select>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.agents.type')}}</label>
                          @php $agentTypes = Helper::get_agent_type_list(); @endphp
                          {{Form::select('agent_type',$agentTypes,null,['class'=>'form-control'])}}
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
						  <span class="mission_hours_note @if(isset($mission->total_hours)) d-none @endif">{{__('dashboard.mission.note_hours')}}</span>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>{{__('dashboard.mission.from_when_start')}}</label><br>
                          <label class="rd_container form-inline">{{__('dashboard.now')}}
                            {{Form::radio('quick_book',1,true,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">{{__('dashboard.mission.later')}}
                            {{Form::radio('quick_book',0,false,['class'=>'mission_start_radio'])}}
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        <div id="misionStartEndDiv" class="col-md-6 form-group @if(!(isset($mission->start_date_time) && $mission->start_date_time!=null)) d-none @endif">
                            <label>{{__('dashboard.mission.start_time')}}</label>
                            {{Form::text('start_date_time',null,['class'=>'form-control datetimepicker','placeholder'=>__('dashboard.mission.start_time')])}}
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
						@if(isset($mission) && !empty($mission->intervention) && !empty($mission->repetitive_mission) && !empty($mission->mission_finish_time))
						<div class="col-md-6 form-group security_patrol_field">
							<label>{{__('dashboard.agents.repetitive_mission')}}</label>
							{{Form::select('repetitive_mission',['same day'=>__('dashboard.agents.same_day'),'week'=>__('dashboard.agents.week')],null,['class'=>'form-control'])}}
						</div>
						<div class="col-md-6 form-group security_patrol_field">
							<label>{{__('dashboard.agents.finish_time')}}</label>
							{{Form::text('mission_finish_time',null,['class'=>'form-control timepicker','placeholder'=>__('dashboard.agents.available_to_place')])}}
						</div>
						<div class="col-md-6 form-group security_patrol_field">
							<label>{{__('dashboard.agents.time_intervel')}}</label>
							{{Form::select('time_intervel',[1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24],null,['class'=>'form-control'])}}
						</div>
						@endif
                        <div class="col-md-12 form-group">
                          <label>{{__('dashboard.mission.description')}}</label>
                          {{Form::textarea('description',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.description_place')])}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="button" data-toggle="modal" data-target="#conform_action" class="button success_btn">{{__('dashboard.mission.book_agent_now')}}</button>
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
<!-- Modal -->
<div id="conform_action" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">{{__('dashboard.confirm')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <p class="confirm_text">{{__('dashboard.mission.confirm_create')}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary success_btn confirmBtn">{{__('dashboard.yes')}}</button>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">{{__('dashboard.no')}}</button>
      </div>
    </div>
  </div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA&libraries=places&callback=initAutocomplete"
    async defer></script>
@endsection