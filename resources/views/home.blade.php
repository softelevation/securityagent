<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Home | On Time</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/location.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
<!--       <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
 -->
<style type="text/css">
    .pac-container{
        z-index: 9999;
    }
</style>
</head>

<body>
<div id="Header">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="{{asset('assets/images/logo.jpg')}}"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="main_menu">
            <div class="menu_left">
                <div class="top_menu">
                    <ul>
                        <li><a href="">Login</a></li> <em>|</em>  <li><a href="">Registration</a></li>
                        <li><div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/images/usa_flag.png')}}"/> USA
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">USA</a></li>
                            <li><a href="#">Australia</a></li>
                            <li><a href="#">India</a></li>
                          </ul>
                        </div></li>
                    </ul>
                </div>
                <div class="primary">
                    <ul>
                        <li><a class="active" href="">Home</a></li>
                        <li><a href="">Available Agent on Map</a></li>
                        <li><a href="">Contact us</a></li>
                    </ul>
                </div>
            </div>  
            <div class="menu_right">
                <a type="button" data-toggle="modal" data-target="#become_agent">Become an Agent</a>
            </div>
        </div>
      </div>
    </div>
  </nav>
</div>
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="banner_cont">
                    <h1>Votre agent de securite des que possible</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map_panel text-center">
                    <h2>Les Meilleurs sont pres de chez vous</h2>    
                    <p>Search by city, address, postalcode, etc...</p>
                    <div class="locationSearch">
                        <input type="search" class="form-control" placeholder="Type location here"/>
                        <span><i class="fa fa-paper-plane"></i></span>
                    </div>
                    <a href="#" class="yellow_btn">Search Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="comment_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>Comment Ca Marche ?</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>
        <p>Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez le nombre de paragraphes, de mots ou de listes. Vous obtenez alors un texte aléatoire que vous pourrez ensuite utiliser librement dans vos maquettes. Lorem Ipsum est un générateur de faux textes aléatoires. Vous choisissez  Vous obtenez alors un librement dans vos maquettes.</p>
    </div>
</div>    
<div class="feature_panel">
    <div class="feature_panel_inner">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-right">
                <div class="feature_box">
                    <span><img src="{{asset('assets/images/awesome_icon.png')}}"/></span>
                    <h3>Awesome Features</h3>
                    <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                </div>
                 <div class="feature_box">
                    <span><img src="{{asset('assets/images/platform_icon.png')}}"/></span>
                    <h3>Cross-Platform</h3>
                    <p>Semper a augue suscript, luctus neque purus ipsum neque primis libero</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature_img">
                    <img src="{{asset('assets/images/mobile_img.png')}}" alt=""/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature_box">
                    <span><img src="{{asset('assets/images/update_icon.png')}}"/></span>
                    <h3>Free Updates</h3>
                    <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                </div>
                 <div class="feature_box">
                    <span><img src="{{asset('assets/images/support_icon.png')}}"/></span>
                    <h3>Fast-Support</h3>
                    <p>Purus ipsum neque primis libero tempor posuere in ligula varius ipsum</p>
                </div>
            </div>
        </div>
    </div>                      
</div>  
    </div>
    <div class="how_works">
        <div class="container">
            <div class="heading text-center">
                <h2>How It Works?</h2>
                <img src="{{asset('assets/images/heading_bottom.png')}}"/>
            </div> 
            <div class="row">
                <div class="col-md-6">
                    <div class="agent">
                        <h4>Agent</h4>
                        <img src="{{asset('assets/images/agent.jpg')}}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="customer">
                        <h4>Customer</h4>
                        <img src="{{asset('assets/images/customer.jpg')}}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="how_work_listing">
                        <ul>
                            <li><a href=""><img src="{{asset('assets/images/search_img.png')}}"/> Inscrivez-vous et creez votre annonce</a></li>
                            <li><a href=""><img src="{{asset('assets/images/copy_img.png')}}"/> Effectuez vos recherches</a></li>
                            <li><a href=""><img src="{{asset('assets/images/calling_img.png')}}"/> Contactez les agents dispoibles</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="testimonial_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>Nos Derniers Temoigna</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>  
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person1.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Robert Peterson</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person2.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Evelyn Martinez</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="testimonial_img">
                                    <img src="{{asset('assets/images/testi_person3.jpg')}}"/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="testimonial_name">
                                    <h4>Dan Hodges</h4>
                                    <div class="star">
                                        <img src="{{asset('assets/images/star.jpg')}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     

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

    
    
    <!-- Trigger the modal with a button -->


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
          <!-- <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Your Password" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Your Password" />
              </div>
            </div>
          </div> -->
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
                <input id="autocomplete" placeholder="Enter your address" class="form-control"  onFocus="geolocate()" type="text"/>
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
      </div>
    </div>
  </div>
</div>
  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

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
  console.log(place.geometry.location.lat());
  console.log(place.geometry.location.lng());
  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
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
      console.log(geolocation);
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } 
}
getLocation();
function showPosition(position) {
  var current_location_lat = document.querySelector("input[name='current_location[lat]']");
  var current_location_long = document.querySelector("input[name='current_location[long]']");
  current_location_lat.value = position.coords.latitude; 
  current_location_long.value = position.coords.longitude;
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA&libraries=places&callback=initAutocomplete"
        async defer></script>
</body>

</html>
