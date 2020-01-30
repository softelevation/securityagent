@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row">    
        <div class="col-md-12">
            <div class="contact_box">
                <h3> View Agent Details</h3>
                <div class="profile_detail_box">
                  <div class="row p-4">
                    <div class="col-md-3 text-center">
                      <div>
                        <img class="rounded-circle avatar-image" src="{{asset('avatars/'.$agent->avatar_icon)}}">
                      </div>
                      <div class="pt-3">
                        <img src="{{asset('assets/images/star.jpg')}}">
                      </div>
                      <div>
                        <ul class="details-list">
                          <li><span>48</span> Missions Completed</li>
                          <li><span>67</span> Hours Completed</li>
                          <li>@if($agent->is_vehicle==1) Having <span>Vehicle</span> @else Without Vehicle @endif</li>
                        </ul>
                        <div class="Quick_Order_Agent p-0 pt-4">
                          <a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" class="bookAgentBtn">Book Agent Now</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="">
                        <h4>{{$agent->username}}</h4>
                        <hr>
                        <h6>{{Helper::get_agent_type_name_multiple($agent->types)}}</h6>
                        <h6>{{$agent->user->email}}</h6>
                      </div>
                      <div class="mt-4">
                        <h3> Agent Documents</h3>
                        <div class="row document-details">
                          @if($agent->identity_card)
                          <a href="{{asset('agent/documents/'.$agent->identity_card)}}" target="_blank" class="col-md-2 text-center hover-box" title="Identity Card">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif
                          @if($agent->social_security_number)
                          <a href="{{asset('agent/documents/'.$agent->social_security_number)}}" target="_blank" class="col-md-2 text-center hover-box" title="Social Security Number">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif
                          @if($agent->cv)
                          <a href="{{asset('agent/documents/'.$agent->cv)}}" target="_blank" class="col-md-2 text-center hover-box" title="Curriculam Vitae">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <h3> Recent Reviews</h3>
                          <div class="row review-wrapper">
                            <div class="review-img">
                              <img class="img-circle" src="{{asset('avatars/dummy_avatar.jpg')}}">
                            </div>
                            <div class="review-text">
                              <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </P>
                              <p class="review-star">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                              </p>  
                            </div>
                          </div>
                          <div class="row review-wrapper">
                            <div class="review-img">
                              <img class="img-circle" src="{{asset('avatars/dummy_avatar.jpg')}}">
                            </div>
                            <div class="review-text">
                              <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </P>
                              <p class="review-star">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="far fa-star"></span>
                              </p>  
                            </div>
                          </div>
                          <div class="row review-wrapper">
                            <div class="review-img">
                              <img class="img-circle" src="{{asset('avatars/dummy_avatar.jpg')}}">
                            </div>
                            <div class="review-text">
                              <P>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </P>
                              <p class="review-star">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                              </p>  
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
    </div>
</div>
{{Form::open(['id'=>'general_form','url'=>url('book-agent')])}}
{{Form::hidden('agent_id',null,['id'=>'bookingAgentId'])}}
{{Form::close()}}
<script>
  $(document).on('click','.bookAgentBtn',function(){
      let id = $(this).attr('id');
      $('#bookingAgentId').val(id);
      $('#general_form').submit();
  });
</script>
@endsection