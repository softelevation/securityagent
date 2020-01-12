@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> Mission Payment</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <!-- Added cards -->
                    <!-- <div class="examples">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Type</th>
                              <th>Card Number</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Visa</td>
                              <td>4716108999716531</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div> -->
                  <div class="creditCardForm">
                    <div class="heading">
                      <h5><i class="fa fa-plus"></i> Add New Card</h5>
                    </div>
                    <hr>
                    <div class="payment">
                      <form method="post" action="{{url('customer/make-mission-payment')}}">
                        <input type="hidden" name="amount" value="{{Helper::encrypt($mission->amount)}}">
                        @csrf
                        <div class="row">
                          <div class="form-group col-md-8 owner">
                            <label for="owner">Card Holder's Name</label>
                            <input type="text" name="name" class="form-control" id="owner">
                          </div>
                          <div class="form-group col-md-4 CVV">
                            <label for="cvc">CVC</label>
                            <input type="text" name="cvc" class="form-control" id="cvv">
                          </div>
                          <div class="form-group col-md-12" id="card-number-field">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" name="card_number" class="form-control" id="cardNumber">
                          </div>
                          <div class="form-group col-md-3" id="expiration-date">
                            <label>Expiration Month</label>
                            <div>
                              <select class="form-control" name="expire_month">
                                  <option value="01">January</option>
                                  <option value="02">February </option>
                                  <option value="03">March</option>
                                  <option value="04">April</option>
                                  <option value="05">May</option>
                                  <option value="06">June</option>
                                  <option value="07">July</option>
                                  <option value="08">August</option>
                                  <option value="09">September</option>
                                  <option value="10">October</option>
                                  <option value="11">November</option>
                                  <option value="12">December</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group col-md-3" id="expiration-date">
                            <label>Expiration Year</label>
                            <div>
                              <select class="form-control" name="expire_year">
                                  <option value="20"> 2020</option>
                                  <option value="21"> 2021</option>
                                  <option value="22"> 2022</option>
                                  <option value="23"> 2023</option>
                                  <option value="24"> 2024</option>
                                  <option value="25"> 2025</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group col-md-6 pt-4 text-right" id="credit_cards">
                            <img src="{{asset('assets/payment/images/visa.jpg')}}" id="visa">
                            <img src="{{asset('assets/payment/images/mastercard.jpg')}}" id="mastercard">
                            <img src="{{asset('assets/payment/images/amex.jpg')}}" id="amex">
                          </div>
                        </div>
                        <hr>
                        <div class="col-md-12 text-center">
                            <input type="hidden" name="mission_id" value="{{Helper::encrypt($mission->id)}}">
                            <button type="submit" class="button success_btn">Make Payment</button>
                        </div>
                        <!-- <div class="form-group" id="pay-now">
                          <button type="submit" class="btn btn-default" id="confirm-purchase">Confirm</button>
                        </div> -->
                      </form>
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