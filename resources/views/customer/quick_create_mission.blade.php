@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Mission</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> Create New Mission</h3>
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
                          <label>Mission Title</label>
                          {{Form::text('title',null,['class'=>'form-control','placeholder'=>'Enter mission title'])}}
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Mission Location</label>
                          {{Form::text('location',null,['id'=>'autocomplete', 'placeholder'=>'Enter your location', 'class'=>'form-control',  'onFocus'=>'geolocate()'])}}
                          <!--Work Location Lat Longs  -->
                          {{Form::hidden('latitude')}}
                          {{Form::hidden('longitude')}}
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
                          <span class="mission_hours_note @if(isset($mission->total_hours)) d-none @endif">Note: You will be charged for 8 Hours, if you don't know how many hours needed.</span>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>From When You Want To Start The Mission?</label><br>
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
                            {{Form::radio('vehicle_required',1,true)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">No
                            {{Form::radio('vehicle_required',2,false)}}
                            <span class="checkmark"></span>
                          </label>
                          <label class="rd_container">Doesn't Matter
                            {{Form::radio('vehicle_required',3,false)}}
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
                            <button type="button" data-toggle="modal" data-target="#conform_action" class="button success_btn">Book An Agent Now</button>
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
        <h4 class="modal-title">Confirm Action</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <p class="confirm_text">Are you sure, you want to create a new mission ?</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary success_btn confirmBtn">Yes</button>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">No</button>
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