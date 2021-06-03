@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row">    
        <div class="col-md-12">
            <div class="contact_box">
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="profile_detail_box">
                  <div class="row p-4">
                    <div class="col-md-3 text-center">
                      <div>
						@if($agent->image && !empty($agent->image))
							<img class="rounded-circle avatar-image" src="{{Helper::api_url($agent->image)}}">
						@else
							<img class="rounded-circle avatar-image" src="{{asset('avatars/'.$agent->avatar_icon)}}">
						@endIf
                      </div>
                      <div class="pt-3">
                        <p class="review-star">
                                <span class="fa fa-star @if($agent->rating >= 1) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 2) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 3) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 4) checked @endIf"></span>
                                <span class="fa fa-star @if($agent->rating >= 5) checked @endIf"></span>
                        </p>
                      </div>
                      <div>
                        <ul class="details-list">
                          <li><span>{{Helper::get_total_missin_completed($agent->id)}}</span> {{__('dashboard.mission.mission_completed')}}</li>
                          <li><span>{{round(Helper::get_total_worked_hours($agent->id))}}</span> {{__('dashboard.mission.hours_completed')}}</li>
                          <li>@if($agent->is_vehicle==1) {!!__('dashboard.mission.have_vehicle')!!} @else {{__('dashboard.mission.no_vehicle')}} @endif</li>
                        </ul>
                        <div class="Quick_Order_Agent p-0 pt-4">
                          <a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" class="bookAgentBtn">{{__('dashboard.mission.book_now')}}</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="">
                        <h4>{{$agent->username}}</h4>
                        <hr>
                        <h6>{{Helper::get_agent_type_name_multiple($agent->agent_type)}}</h6>
                      </div>
                      <div class="mt-4">
                        <h3>{{__('dashboard.agents.docs')}}</h3>
                        <div class="row document-details">
                          @if($agent->cv)
                          <a href="{{asset('agent/documents/'.$agent->cv)}}" target="_blank" class="col-md-2 text-center hover-box" title="Curriculam Vitae">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif
                          @php $agentTypes = explode(',',$agent->agent_type); $diploma=0; $dog = 0; @endphp
                          @foreach($agentTypes as $type)
                            @if($type==1 || $type==2 || $type==3) 
                              @php $diploma = 1; @endphp
                            @endif
                            @if($type==6) 
                              @php $dog = 1; $dogDoc = $type; @endphp
                            @endif
                          @endforeach

                          @if($dog==1)
                          <a href="{{asset('agent/documents/'.$dogDoc)}}" target="_blank" class="col-md-2 text-center hover-box" title="Mutal Dog Info Document">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif

                        </div>
                      </div>
					  <div class="row">
                        <div class="col-md-12">
                          <h3>{{__('dashboard.agents.reviews')}}</h3>
						  @foreach($agent->feedbacks as $feedback)
                          <div class="row review-wrapper">
                            <div class="review-img">
								<img class="img-circle" src="{{asset('avatars/dummy_avatar.jpg')}}">
                            </div>
                            <div class="review-text">
                              <P>{{$feedback->message}}</P>
                              <p class="review-star">
                                <span class="fa fa-star @if($feedback->rating >= 1) checked @endIf"></span>
                                <span class="fa fa-star @if($feedback->rating >= 2) checked @endIf"></span>
                                <span class="fa fa-star @if($feedback->rating >= 3) checked @endIf"></span>
                                <span class="fa fa-star @if($feedback->rating >= 4) checked @endIf"></span>
                                <span class="fa fa-star @if($feedback->rating >= 5) checked @endIf"></span>
                              </p>  
                            </div>
                          </div>
						  @endforeach
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
{{Form::hidden('distance',$distance,['id'=>'bookingAgentDistance'])}}
{{Form::close()}}
<script>
  $(document).on('click','.bookAgentBtn',function(){
      let id = $(this).attr('id');
      $('#bookingAgentId').val(id);
      $('#general_form').submit();
  });
</script>
@endsection