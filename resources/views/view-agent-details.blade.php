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
                        <img class="rounded-circle avatar-image" src="{{asset('avatars/'.$agent->avatar_icon)}}">
                      </div>
                      <div class="pt-3">
                        <img src="{{asset('assets/images/star.jpg')}}">
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
                        <h6>{{Helper::get_agent_type_name_multiple($agent->types)}}</h6>
                      </div>
                      <div class="mt-4">
                        <h3>{{__('dashboard.agents.docs')}}</h3>
                        <div class="row document-details">
                          @if($agent->cv)
                          <a href="{{asset('agent/documents/'.$agent->cv)}}" target="_blank" class="col-md-2 text-center hover-box" title="Curriculam Vitae">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif
                          @php $agentTypes = $agent->types; $diploma=0; $dog = 0; @endphp
                          @foreach($agentTypes as $type)
                            @if($type->agent_type==1 || $type->agent_type==2 || $type->agent_type==3) 
                              @php $diploma = 1; @endphp
                            @endif
                            @if($type->agent_type==6) 
                              @php $dog = 1; $dogDoc = $type->dog_info; @endphp
                            @endif
                          @endforeach

                          @if($dog==1)
                          <a href="{{asset('agent/documents/'.$dogDoc)}}" target="_blank" class="col-md-2 text-center hover-box" title="Mutal Dog Info Document">
                            <i class="fas fa-file"></i> <br>
                          </a>
                          @endif

                        </div>
                      </div>
                      <!-- div class="row">
                        <div class="col-md-12">
                          <h3>{{__('dashboard.agents.reviews')}}</h3>
                         
                          
                        </div>
                      </div -->
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