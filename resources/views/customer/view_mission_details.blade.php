@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3> View Mission Deatils</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    
                      <div class="row">
                        <div class="col-md-6">
                          <h5>Your Mission Summary</h5>
                          <hr>
                          <label>Mission Title : </label> {{$mission->title}}<br>
                          <label>Mission Location : </label> {{$mission->location}}<br>
                          <label>Agent Required: </label> {{Helper::get_agent_type_name($mission->agent_type)}}<br>
                          <label>Mission Hours: </label> {{$mission->total_hours}} Hour(s)<br>
                          <label>Mission Description: </label> 
                          {{$mission->description}}<br>
                          <label>Mission Status: </label> 
                          {{Helper::getMissionStatus($mission->status)}}
                        </div>   
                        <div class="col-md-6">
                          <h5>Available Agent's Details</h5>
                          <hr>
                          <label>Agent Name : </label> {{ucfirst($mission->agent_details->username)}}<br>
                          <label>Agent Type : </label> {{Helper::get_agent_type_name_multiple($mission->agent_details->types)}}<br>
                          <label>Missions Completed : </label> 42<br>
                          <label>Agent Rating : </label> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><br>
                        </div> 
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-12">
                          <h5>Payment Details</h5>
                          <label>Mission Amount:</label> {{$mission->amount}} <i class="fa fa-euro-sign"></i><br>
                          <label>Payment Status:</label> @if($mission->payment_status==0) Not Paid Yet @else Completed @endif
                        </div>
                      </div>
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
  $(function() {
    $( ".datepicker" ).datepicker();
  });

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