<!-- Footer -->
<footer class="footer">
  <div class="container">
     <div class="row">
         <div class="col-md-4">
          <div class="about_info">
              <h3>About our platform</h3>
              <p>Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, de mots ou de listes. Vous obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes. Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, listes. obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes.</p>   
          </div>
         </div>
         <div class="col-md-4">
          <div class="shortLink">
              <h3>Short links</h3>
              <ul>
                  <li><a href=""><i class="fa fa-share" aria-hidden="true"></i> contact</a></li>
                  <li><a href=""><i class="fa fa-share" aria-hidden="true"></i> available agent on map</a></li>
              </ul> 
              <div class="social_sprite">
                  <a class="facebook" href=""></a>
                  <a class="google" href=""></a>
                  <a class="twitter" href=""></a>
                  <a class="instagram" href=""></a>
              </div>
          </div>
         </div>
         <div class="col-md-4">
          <div class="newsletter">
              <h3>Newsletter</h3>
              <p>Sign up for our newsletter and be informed of all the news in preview!</p>   
              <div class="newsletter_box">
                  <input type="text" class="form-control" placeholder="Your Email Here"/>
                  <span><i class="fa fa-envelope"></i></span>
                  <input type="button" class="btn_submit" value="Submit" />
              </div>
          </div>
         </div>
      </div>
      <div class="copyright text-center">
          <p>Copyright © 2019 - Alright reserved by <b>OnTimeBee</b>. Design By: <b>CMO Agency</b></p>
      </div>
  </div>
</footer>
<!-- Modal -->
<div id="become_agent" class="modal fade " role="dialog" >
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Become an Agent</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="general_form" method="post" action="{{url('register_agent')}}" enctype="multipart/form-data">
            @csrf
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
                <input type="email" name="email" class="form-control" placeholder="Enter Your Email" />
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
            <div class="col-md-6">
              <div class="form-group">
                <label>Identity Card</label><br>
                <input type="file" name="identity_card" class="" placeholder="Upload Your ID Proof Document" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Social Security Number</label><br>
                <input type="file" name="social_security_number" class="" placeholder="Upload Your Agent Number Document" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Agent Type</label>
                <select class="form-control" name="agent_type">
                    <option>Select</option>
                    <option value="1">Agent SSIP 1</option>
                    <option value="2">Agent SSIP 2</option>
                    <option value="3">Agent SSIP 3</option>
                    <option value="4">ADS With Vehicule or Not</option>
                    <option value="5">Body Guard Without Weapon</option>
                    <option value="7">Hostesses</option>
                    <option value="6">Dog Handler</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>CNAPS Number</label>
                    <input type="text" name="cnaps_number" class="form-control" placeholder="Enter Your CNAPS Number " />
              </div>
            </div>
          </div>
          <div class="row">
               <div class="col-md-12">
              <div class="form-group">
                <label>Home Address</label>
                    <input type="text" name="home_address" class="form-control" placeholder="Enter Your home address " />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Work Location</label>
                <input id="autocomplete" name="work_location_address" placeholder="Enter your address" class="form-control"  onFocus="geolocate()" type="text"/>
                <!--Work Location Lat Longs  -->
                <input type="hidden" name="work_location[lat]" />
                <input type="hidden" name="work_location[long]" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="current_location[lat]" />
                <input type="hidden" name="current_location[long]" />
              <div class="form-group">
                <input type="submit" class="yellow_btn" value="Become Agent"/>
              </div>
            </div>
          </div>
        </form>          
      </div>
    </div>
  </div>
</div>

<!-- Google Place API -->
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

// function getLocation() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(showPosition);
//   } 
// }
// getLocation();
// function showPosition(position) {
//   var current_location_lat = document.querySelector("input[name='current_location[lat]']");
//   var current_location_long = document.querySelector("input[name='current_location[long]']");
//   current_location_lat.value = position.coords.latitude; 
//   current_location_long.value = position.coords.longitude;
// }
// function initialize(){
//   initAutocomplete();
// }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA&libraries=places&callback=initAutocomplete"
    async defer></script>
<!-- Bootstrap core JavaScript -->
<script> var app_base_url = "{{url('/')}}"; </script>

<script src="{{asset('js/jquery.toast.js')}}"></script>
<script src="{{asset('js/form-validate.js')}}"></script>
<script src="{{asset('js/jquery.validate.js')}}"></script>
</body>
</html>