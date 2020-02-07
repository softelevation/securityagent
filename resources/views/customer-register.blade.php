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
@endsection