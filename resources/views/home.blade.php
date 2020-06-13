@extends('layouts.app')
@section('content')
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="banner_cont">
                    <h1>{{__('frontend.text_1')}}</h1>
                    <p>{{__('frontend.text_6')}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map_panel text-center contact_box ">
                    <h2>{{__('frontend.text_2')}}</h2>    
                    <p>{{__('frontend.text_3')}}</p>
                    <form method="get" action="{{url('/available-agents')}}">
                    <div class="locationSearch">
                        <input id="autocomplete" name="location" placeholder="{{__('frontend.text_4')}}" class="form-control"  onFocus="geolocate()" type="text"/>
                            <!--Work Location Lat Longs  -->
                        <input type="hidden" name="latitude" />
                        <input type="hidden" name="longitude" />
                        <span><i class="fa fa-paper-plane"></i></span>
                    </div>
                    <button class="yellow_btn">{{__('frontend.text_5')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="comment_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>{{__('frontend.text_32')}}</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>
        <p>{{__('frontend.text_7')}}</p>
    </div>
</div>    
<div class="how_works">
    <div class="container"> 
        <div class="row">
            <div class="col-md-6">
                <div class="agent">
                    <h4>{{__('frontend.text_8')}}</h4>
                    <img src="{{asset('assets/images/agent_2.png')}}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="customer">
                    <img src="{{asset('assets/images/client.png')}}"/>
                    <h4>{{__('frontend.text_9')}}</h4>                        
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="how_work_listing">
                    <ul>
                        <li><a href=""><span><i class="fa fa-search"></i></span>{{__('frontend.text_10')}}</a></li>
                        <li><a href=""><span><i class="fa fa-copy"></i></span>{{__('frontend.text_11')}}</a></li>
                        <li><a href=""><span><i class="fa fa-phone"></i></span>{{__('frontend.text_12')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="feature_panel">
    <div class="feature_panel_inner">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-right">
                <div class="feature_box">
                    <span><img src="{{asset('assets/images/awesome_icon.png')}}"></span>
                    <h3>{{__('frontend.text_13')}}</h3>
                    <p>{{__('frontend.text_14')}}</p>
                </div>
                 <div class="feature_box">
                    <span><img src="{{asset('assets/images/platform_icon.png')}}"></span>
                    <h3>{{__('frontend.text_15')}}</h3>
                    <p>{{__('frontend.text_16')}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature_img">
                    <img src="{{asset('assets/images/mobile_img.png')}}" alt="">
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature_box">
                    <span><img src="{{asset('assets/images/update_icon.png')}}"></span>
                    <h3>{{__('frontend.text_17')}}</h3>
                    <p>{{__('frontend.text_18')}}</p>
                </div>
                 <div class="feature_box">
                    <span><img src="{{asset('assets/images/support_icon.png')}}"></span>
                    <h3>{{__('frontend.text_19')}}</h3>
                    <p>{{__('frontend.text_20')}}</p>
                </div>
            </div>
        </div>
    </div>                      
</div>  
    </div>
<div class="testimonial_panel">
    <div class="container">
        <div class="heading text-center">
            <h2>{{__('frontend.text_21')}}</h2>
            <img src="{{asset('assets/images/heading_bottom.png')}}"/>
        </div>  
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial_box">
                    <div class="testimonial_cont">
                        <p>{{__('frontend.text_22')}}</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="testimonial_name">
                                    <h4>T. Magnis</h4>
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
                        <p>{{__('frontend.text_23')}}</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="testimonial_name">
                                    <h4>E. Delattre</h4>
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
                        <p>{{__('frontend.text_24')}}</p>
                    </div>
                    <div class="testimonial_img_name">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="testimonial_name">
                                    <h4>A. Dembert</h4>
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
