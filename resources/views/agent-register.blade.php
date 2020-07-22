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
                <h3>
					{{__('frontend.text_94')}}
					<span style="margin-left:30px;float:right">					
						{{__('frontend.text_941')}}
					</span>
				</h3>
				

                <form id="general_form" method="post" action="{{url('/register_agent')}}" enctype="multipart/form-data" novalidate="novalidate">
                	@csrf
	                <div class="contact_form">
	                  	<div class="row">
		                    <div class="col-md-6">
		                      	<div class="form-group">
			                       	<label>{{__('frontend.text_95')}}</label>
				                	<input type="text" name="first_name" class="form-control validation" placeholder="{{__('frontend.text_96')}}" />
			             	  	</div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_97')}}</label>
				                <input type="text" name="last_name" class="form-control validation" placeholder="{{__('frontend.text_98')}}" />
		                      </div>
		                    </div>
	                	</div>

	                    <div class="row">
	     					<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_99')}}</label>
				                <input type="text" name="email" class="form-control validation" placeholder="{{__('frontend.text_100')}}" />
		                      </div>
		                    </div>
	                      	<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_101')}}</label>
				                <input type="text" name="phone" class="form-control validation" placeholder="{{__('frontend.text_102')}}" />
		                      </div>
	                    	</div>
	               		</div>
	                	<div class="row">
	                		<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_103')}}</label><br>
	                      		<div class="custom-file">
				                	<input type="file" name="identity_card" class="custom-file-input validation" id="identityCard"/>
		                         	<label class="custom-file-label" for="identityCard"> {{__('frontend.text_104')}} </label>
	                     		</div>
		                      </div>
	                    	</div>
		                  <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_105')}}</label><br>
				                <div class="custom-file">
				                	<input type="file" name="social_security_number" class="custom-file-input validation" id="socialSecurityNumber"/>
		                         	<label class="custom-file-label" for="socialSecurityNumber"> {{__('frontend.text_106')}} </label>
	                     		</div>
		                      </div>
		                    </div>
	                	</div> 
	                	<div class="row">
	                		<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_107')}} </label><br>
				                <div class="custom-file">
				                	<input type="file" name="cv" class="custom-file-input validation" id="cv"/>
		                         	<label class="custom-file-label" for="cv"> {{__('frontend.text_108')}} </label>
	                     		</div>
		                      </div>
	                    	</div>
		                  	<div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_109')}}</label><br>
				                <input type="text" name="iban" class="form-control validation" placeholder="{{__('frontend.text_110')}}" />
		                      </div>
		                    </div>
	                	</div> 

	                   <div class="row">
		                    <div class="col-md-6">
		                      <div class="form-group ">
					                @php $agentTypes = Helper::get_agent_type_list(); @endphp
					                <label>{{__('frontend.text_111')}}</label>
					                <input type="hidden" name="agent_type" id="agent_type_hidden">
					                <select class="form-control multi_select validation" multiple="multiple" id="select_agent_type" placeholder="Choose Agent Type">
					                    @foreach($agentTypes as $key => $agent_types)
					                    	<option value="{{$key}}">{{$agent_types}}</option>
					                    @endforeach
					                    <!-- <option value="1">Agent SSIAP 1</option>
					                    <option value="2">Agent SSIAP 2</option>
					                    <option value="3">Agent SSIAP 3</option>
					                    <option value="4">ADS</option>
					                    <option value="5">Body Guard Without Weapon</option>
					                    <option value="6">Dog Handler</option>
					                    <option value="7">Hostesses</option> -->
					                </select>
			                    </div>
		                    </div>
							<div class="col-md-6" >
		                      	<div class="form-group ">
					                <label>{{__('frontend.text_113')}}</label>
				                    <input type="text" name="cnaps_number" class="form-control cnaps_number" placeholder="{{__('frontend.text_114')}}" />
		                     	</div>
		                    </div>
	                  </div>   
	                  <div class="row diploma  d-none">
	                		<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_123')}}</label><br>
				                <div id="diploma-group">
					                <div class="custom-file mt-2">
					                	<input type="file" name="diploma[]" class="custom-file-input" id="diploma1"/>
			                         	<label class="custom-file-label" for="diploma1"> {{__('frontend.text_124')}} 1</label>
		                     		</div>
				                </div>
				                <button type="button" class="add-diploma-btn btn btn-secondary mt-3" title="Add files">+</button>
				                <button type="button" class="remove-diploma-btn btn btn-danger d-none mt-3" title="Remove files">-</button>
		                      </div>
	                    	</div>
	                    </div>
	                    <div class="row d-none dog_info">
		                    <div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_125')}}</label><br>
				                <div class="custom-file">
				                	<input type="file" name="dog_info" class="custom-file-input" id="dog_info"/>
		                         	<label class="custom-file-label" for="dog_info"> {{__('frontend.text_126')}}</label>
	                     		</div>
		                      </div>
		                    </div>
	                  	</div>
	                   	<div class="row">
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_115')}}</label>
			                    <input type="text" name="home_address" class="form-control validation" placeholder="{{__('frontend.text_116')}}" />
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_117')}}</label>
				                <input id="autocomplete" name="work_location_address" placeholder="{{__('frontend.text_118')}}" class="form-control validation"  onFocus="geolocate()" type="text"/>
				                <!--Work Location Lat Longs  -->
				                <input type="hidden" name="work_location[lat]" />
				                <input type="hidden" name="work_location[long]" />
		                      </div>
		                    </div>
	                  	</div>  
	                  	<div class="row">
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_119')}}</label><br>
			                    <input type="radio" name="is_vehicle" value="1"> {{__('frontend.text_120')}}
			                    <input type="radio" name="is_vehicle" value="0" checked> {{__('frontend.text_121')}}
		                      </div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.sub_contract_title')}}</label><br>
			                    <input type="radio" class="is_subc" name="is_subcontractor" value="1"> {{__('frontend.text_120')}}
			                    <input type="radio" class="is_subc" name="is_subcontractor" value="0" checked> {{__('frontend.text_121')}}
		                      </div>
		                    </div>
	                  	</div>
	                  	<div class="row">
		                    <div class="col-md-6 d-none suppl_comp">
		                      <div class="form-group ">
				                <label>{{__('frontend.suplier_title')}}</label>
			                    <input type="text" name="supplier_company" class="form-control" placeholder="{{__('frontend.suplier_title_place')}}" />
		                      </div>
		                    </div>
		                </div>  
		                <div class="row">
	                  		<div class="col-md-6">
		                      <div class="form-group ">
				                <label>Captcha</label><br>
				                <div class="captcha">
				                	<span class="captcha-img">{!! captcha_img() !!}</span>
				                	<button data-url="{{url('refresh-captcha')}}" type="button" class="btn btn-warning captcha_refresh">Refresh</button>
				                </div>
			                    <input type="text" name="captcha" class="form-control mt-2 validation" placeholder="{{__('frontend.captcha_place')}}" />
		                      </div>
		                    </div>
	                  	</div>
		                <div class="text-center pt-5 text_panel">
						<input type="checkbox" name="terms_conditions" value="1">{!! trans('frontend.reg_term_and_condition_1') !!} </br>
						<input type="checkbox" name="terms_conditions" value="2">{!! trans('frontend.reg_term_and_condition_2') !!}
		                	<!-- <input type="checkbox" name="terms_conditions" value="1">{!!__('frontend.terms_conditions_text1',['url'=>url('terms-conditions')])!!}</a>. -->
		                </div>
	                  <div class="row text-center pt-3">
	                    <div class="col-md-12">
		                    <input type="hidden" name="current_location[lat]" />
			                <input type="hidden" name="current_location[long]" />
				            <div class="form-group">
				               <input type="button" onClick="checkValidation()" class="yellow_btn" value="{{__('frontend.text_122')}}"/>
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
var locale = '@php echo Session::get("locale"); @endphp';
/*
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
*/

function checkValidation(){ 
	var no = 1;	
	var empty = true;
	$('.validation').each(function(){
		console.log($(this).val(),'sssssss');
		if($(this).val() == ""){
			empty = false;
			$(this).css('border-color','red');
			$(this).parent('.custom-file').css('border','1px solid red');
			$(this).next().next('.select2.select2-container').css('border','1px solid red');
			if(no == 1){
				toastr.error('* Indicates the required fields',4000);
			}
			no++;
			//return false;
		}else{
			empty = true;
		}
	});
	
	if(empty){
		$( "#general_form" ).submit();
	}
} 

$(document).on('click','.is_subc',function(){
	if($(this).val()==1){
		$('.suppl_comp').removeClass('d-none');
	}else{
		$('.suppl_comp').addClass('d-none');
	}
});	

//script for SIAP 
$('#select_agent_type').change(function(){
	var values = [];
    let cnapsShow = 0;
	$(this).children("option:selected").each(function(i,val){
    	let value = $(this).val();
    	if(value > 3){
    		cnapsShow = 1;
    	}
		values.push(value);
    });
	if(cnapsShow == 0){
		$('.cnaps_number').prop('disabled',true);
	}else{
		$('.cnaps_number').prop('disabled',false);
	}
    if(values.includes("1") || values.includes("2") || values.includes("3")){
		$('.diploma').removeClass('d-none');
	}else{
		$('.diploma').addClass('d-none');
	}
	if(values.includes("6")){
		$('.dog_info').removeClass('d-none');
	}else{
		$('.dog_info').addClass('d-none');
	}

	$(document).find('#agent_type_hidden').val(JSON.stringify(values));
});

$('.add-diploma-btn').click(function(){
	let totalItems = $('#diploma-group').children().length+1;
	var txt = 'Upload Your Diploma Certificate';
	if(locale=='fr'){
		txt = 'Téléchargez votre curriculum vitae';
	}
	let diploma_label = '<div class="custom-file mt-2"><input type="file" name="diploma[]" class="custom-file-input" id="diploma'+totalItems+'"/><label class="custom-file-label" for="diploma'+totalItems+'">'+txt+' '+totalItems+'</label></div>';
	$('#diploma-group').append(diploma_label);
	$('.remove-diploma-btn').removeClass('d-none');
});

$('.remove-diploma-btn').click(function(){
	let lbl_length = $('#diploma-group').children().length;
	let last_label = $('#diploma-group').children().last();
	if(lbl_length == 2){
		$(this).addClass('d-none');
		last_label.remove();
		return false;
	}
	last_label.remove();
});

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