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
                <h3><i class="fa fa-pin"></i> {{__('frontend.text_144')}}
					<span style="margin-left:30px;float:right">					
						{{__('frontend.text_941')}}
					</span>
				</h3>
                <form id="general_form" method="post" action="{{url('/register_customer_form')}}" novalidate="novalidate">
                	@csrf
	                <div class="contact_form">
	                  	<div class="row">
		                    <div class="col-md-6">
		                      	<div class="form-group">
			                       	<label>{{__('frontend.text_127')}}</label>
				                	<input type="text" name="first_name" class="form-control validation" placeholder="{{__('frontend.text_128')}}" />
			             	  	</div>
		                    </div>
		                    <div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_129')}}</label>
				                <input type="text" name="last_name" class="form-control validation" placeholder="{{__('frontend.text_130')}}" />
		                      </div>
		                    </div>
	                	</div>

	                    <div class="row">
	     					<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_131')}}</label>
				                <input type="text" name="email" class="form-control validation" placeholder="{{__('frontend.text_132')}}" />
		                      </div>
		                    </div>
	                      	<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_133')}}</label>
				                <input type="text" name="phone" class="form-control validation" placeholder="{{__('frontend.text_134')}}" />
		                      </div>
	                    	</div>
	               		</div>

	               		<div class="row">
	     					<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_135')}}</label>
				                <input type="password" name="password" class="form-control validation" placeholder="{{__('frontend.text_136')}}" />
		                      </div>
		                    </div>
	                      	<div class="col-md-6">
		                      <div class="form-group">
				                <label>{{__('frontend.text_137')}}</label>
				                <input type="password" name="password_confirmation" class="form-control validation" placeholder="{{__('frontend.text_138')}}" />
		                      </div>
	                    	</div>
	               		</div>
	                   	<div class="row">
		                    <div class="col-md-12">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_139')}}</label>
			                    <input type="text" name="home_address" class="form-control validation" placeholder="{{__('frontend.text_140')}}" />
		                      </div>
		                    </div>

	                  	</div>  
	                  	<div class="row">
		                    <div class="col-md-6">
		                      <div class="form-group ">
				                <label>{{__('frontend.text_141')}}</label><br>
			                    <input type="radio" name="customer_type" value="1" checked> {{__('frontend.text_142')}}
			                    <input type="radio" name="customer_type" value="2"> {{__('frontend.text_143')}}
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
	                  	<div class="text-center pt-2 text_panel">
						  <div class="text-center pt-5 text_panel">
							<input type="checkbox" name="terms_conditions" value="1">{!! trans('frontend.reg_term_and_condition_1') !!}</br>
							<input type="checkbox" name="terms_conditions" value="2">{!! trans('frontend.reg_term_and_condition_2') !!}
	                  		<!-- <input type="checkbox" name="terms_conditions" value="1">{!!__('frontend.terms_conditions_text2',['url'=>url('terms-conditions')])!!}</a>.</div>   -->
	                  <div class="row text-center pt-3">
	                    <div class="col-md-12">
				            <div class="form-group">
				               <input type="button" onClick="checkValidation();" class="yellow_btn" value="{{__('frontend.text_144')}}"/>
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
@endsection

<script>
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
				toastr.error("{{__('frontend.text_149')}}",4000);
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

</script>