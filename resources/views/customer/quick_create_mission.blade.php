@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> Create New Mission</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <form id="general_form" method="post" action="{{url('customer/save-mission')}}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>Mission Title</label>
                          <input name="title" placeholder="Enter mission title" class="form-control" type="text"/>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Mission Location</label>
                          <input id="autocomplete" name="location" placeholder="Enter your location" class="form-control"  onFocus="geolocate()" type="text"/>
                              <!--Work Location Lat Longs  -->
                          <input type="hidden" name="latitude" />
                          <input type="hidden" name="longitude" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <label>Agent Type</label>
                          <select name="agent_type" class="form-control">
                            @php $agentTypes = Helper::get_agent_type_list(); @endphp
                            @foreach($agentTypes as $key=>$type)
                            <option value="{{$key}}">@if(empty($type)) Select @else {{$type}} @endif</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Hours Required</label>
                          <select name="total_hours" class="form-control">
                            @for($i=1; $i<=24; $i++)
                            <option value="{{$i}}">{{$i}} @if($i==1) Hour @else Hours @endif</option>
                            @endfor
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 form-group">
                          <label>Mission Description</label>
                          <textarea class="form-control" name="description" placeholder="Enter mission description"></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="quick_book" value="1">
                            <button type="button" data-toggle="modal" data-target="#conform_action" class="button success_btn">Book An Agent Now</button>
                        </div>
                      </div>
                    </form>
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