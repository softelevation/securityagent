@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Mission</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
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
                          @if($mission->quick_book==0)
                            <label>Start Datetime: </label> {{date('m/d/Y H:i:s', strtotime($mission->start_date_time))}}<br>
                          @endif
                          <label>Mission Amount: </label> {{$mission->amount}} <i class="fa fa-euro-sign"></i><br>
                          <label>Mission Description: </label> 
                          {{$mission->description}}
                        </div>   
                        <div class="col-md-6">
                          @if($agent)
                          <h5>Available Agent's Details</h5>
                          <hr>
                          <label>Agent Name : </label> {{ucfirst($agent->username)}}<br>
                          <label>Agent Type : </label> {{Helper::get_agent_type_name_multiple($agent->types)}}<br>
                          <label>Missions Completed : </label> 42<br>
                          <label>Agent Rating : </label> <span class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><br>
                          @endif
                        </div> 
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-12 text-center">
                          <h5>Charge Amount: {{$charge_amount}} <i class="fa fa-euro-sign"></i></h5>
                            @if($mission->quick_book==0)<small class="note-div">You will be charged for 30% of the total mission amount for now. Rest of the amount will get deducted automatically after completion of your mission.</small><br>@endif
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