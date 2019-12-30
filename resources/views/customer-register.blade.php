@extends('layouts.app')
@section('content')
<style type="text/css">
	.add-diploma-btn,.remove-diploma-btn{
		position: relative;
    	top: -5px;
    	left: 5px;
	}
	.remove-diploma-btn{
		left: 10px;
	}
</style>

<div class="contact_panel">
  <div class="container">
    <div class="row"> 
        <div class="col-md-12">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> Become An User</h3>
                <form id="general_form" method="post" action="{{url('/register_customer_form')}}" novalidate="novalidate">
                	@csrf
	                <div class="contact_form">
	                  	<div class="row">
		                    <div class="col-md-6">
		                      	<div class="form-group">
			                       	<label>First Name</label>
				                	<input type="text" name="first_name" class="form-control" placeholder="Enter Your First Name" />
			             	  	</div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
				                <label>Last Name</label>
				                <input type="text" name="last_name" class="form-control" placeholder="Enter Your last Name" />
		                      </div>
		                    </div>
	                	</div>

	                    <div class="row">
	     					<div class="col-md-6">
		                      <div class="form-group">
				                <label>Email Address</label>
				                <input type="text" name="email" class="form-control" placeholder="Enter Your Email" />
		                      </div>
		                    </div>
	                      	<div class="col-md-6">
		                      <div class="form-group">
				                <label>Phone Number</label>
				                <input type="text" name="phone" class="form-control" placeholder="Enter Your Phone Number" />
		                      </div>
	                    	</div>
	               		</div>
	                	 
	                   	<div class="row">
		                    <div class="col-md-12">
		                      <div class="form-group ">
				                <label>Home Address</label>
			                    <input type="text" name="home_address" class="form-control" placeholder="Enter Your home address " />
		                      </div>
		                    </div>

	                  	</div>  
	                  	<div class="row">
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>Are you an individual or company ?</label><br>
			                    <input type="radio" name="customer_type" value="1"> Individual
			                    <input type="radio" name="customer_type" value="2"> Company
		                      </div>
		                    </div>
	                  	</div>  
	                  <div class="row text-center pt-3">
	                    <div class="col-md-12">
				            <div class="form-group">
				               <input type="submit" class="yellow_btn" value="Become User"/>
				            </div>
	                    </div>
	                  </div>  
	                </div>
            	</form>
            </div>
        </div>        
    </div>  
    </div>
</div>


          
<!-- Google Place API -->
<script>
$(document).on('change','input[type="file"]', function(e){
    var fileName = e.target.files[0].name;
    $(this).next().text(fileName);
});



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
  var work_location_lat = document.querySelector("input[name='work_location[lat]']");
  var work_location_long = document.querySelector("input[name='work_location[long]']");
  work_location_lat.value = place.geometry.location.lat(); 
  work_location_long.value = place.geometry.location.lng(); 
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
      // set current position
      var current_location_lat = document.querySelector("input[name='current_location[lat]']");
      var current_location_long = document.querySelector("input[name='current_location[long]']");
      current_location_lat.value = position.coords.latitude; 
      current_location_long.value = position.coords.longitude;
      
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA&libraries=places&callback=initAutocomplete"
    async defer></script>
<!-- Bootstrap core JavaScript -->
@endsection