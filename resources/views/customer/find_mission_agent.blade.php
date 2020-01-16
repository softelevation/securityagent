@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3><i class="fa fa-edit"></i> Book An Agent Now</h3>
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
                          {{$mission->description}}
                        </div>   
                        <div class="col-md-6">
                          <h5>Available Agent's Details</h5>
                          <hr>
                          <label>Agent Name : </label> {{ucfirst($agent->username)}}<br>
                          <label>Agent Type : </label> {{Helper::get_agent_type_name_multiple($agent->types)}}<br>
                          <label>Missions Completed : </label> 42<br>
                          <label>Agent Rating : </label> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><br>
                        </div> 
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <h5>Mission Amount: {{$mission->amount}} <i class="fa fa-euro-sign"></i></h5>
                            <a href="{{url('customer/proceed-payment/')}}/{{Helper::encrypt($mission->id)}}" class="button success_btn">Proceed to Checkout</a>
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
@endsection