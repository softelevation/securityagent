@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.missions')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.mission.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
					  @if($mission->agent_type)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.type')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
					  @endif
					  @if($mission->total_hours)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.hours_req')}}</label>
                        <span class="form-control">{{$mission->total_hours}}</span>
                      </div>
					  @endif
					  @if($mission->agent_count || $mission->agent)
					  <div class="col-md-6 form-group">
                        <label>{{__('frontend.mission_request.how_many_agents')}}</label>
                        <span class="form-control">{{ ($mission->agent_count) ? $mission->agent_count: count($mission->agent)}}</span>
                      </div>
					  @endif
					  <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                </div>
              </div>
            </div>
			@if(isset($mission->agent))
			<h3>{{__('dashboard.agents.schedule')}}</h3>
			<div class="pending-details">
			  <div class="view_agent_details mt-4">
				<div class="table-responsive">
					<table class="table table-hover table-striped">
					  <thead>
						  <tr>
							  <th>#</th>
							  <th>From date</th>
							  <th>To date</th>
							  <th>{{__('dashboard.mission.hours_req')}}</th>
							  <th>{{__('dashboard.status')}}</th>
						  </tr>
					  </thead>
					  <tbody>
						@php $i = 0; @endphp
						@foreach($mission->agent as $result)
						@php $i++; @endphp
							<tr>
							  <td>{{$i}}.</td>
							  <td>{{$result->start_date_time}}</td>
							  <td>{{$result->end_date_time}}</td>
							  <td>{{$result->duration}}</td>
							  <td>
							  @if($result->status==0)
								<button data-toggle="modal" data-target="#mission_action" data-url="travel-to-mission" data-type="travel" data-custom_id="{{$result->id}}" class="cus-button success_btn confirmBtn">{{__('dashboard.mission.travel_to_mission')}}</button>
							  @elseif($result->status==1)
								<button data-toggle="modal" data-target="#mission_action" data-url="arrived-to-mission" data-type="arrived" data-custom_id="{{$result->id}}" class="cus-button success_btn confirmBtn">{{__('dashboard.mission.arrived_to_mission')}}</button>
							  @elseif($result->status==2)
								<button data-toggle="modal" data-target="#mission_action" data-url="start-mission" data-type="start" data-custom_id="{{$result->id}}" class="cus-button success_btn confirmBtn">{{__('dashboard.mission.start_mission')}}</button>
							  @elseif($result->status==3)
								<button data-toggle="modal" data-target="#mission_action" data-url="finish-mission" data-type="finish" data-custom_id="{{$result->id}}" class="cus-button success_btn confirmBtn">{{__('dashboard.mission.finish_mission')}}</button>
							  @elseif($result->status==4)
								<button class="btn btn-outline-success status_btn">{{__('dashboard.mission.finished')}}</button>
							  @endif
							  </td>
							</tr>
						@endforeach
					  </tbody>
					</table>
				</div>
			  </div>
			</div>
			@endif
          </div>
            <!-- /.col-md-8 -->
        </div>

    </div>
    <!-- /.container -->
</div>

<!-- Modal -->
<div id="mission_action" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">{{__('dashboard.confirm')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="general_form_sockit" class="mission_action_form" name="" method="post" action="" novalidate="novalidate">
      @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <p class="confirmation_text"></p>
                <input type="hidden" name="mission_id" value="{{$mission->id}}">
                <input type="hidden" name="custom_id" value="">
                <input id="actionInput" type="hidden" name="action_value">  
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary success_btn" >{{__('dashboard.yes')}}</button>
          <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">{{__('dashboard.close')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{Form::open(['url'=>url('agent/create-sub-missions'),'id'=>'general_form_2'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->id))}}
{{Form::close()}}
@endsection

@section('script')
<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
<script>
	var locale = '@php echo app()->getLocale(); @endphp';
	let socket = io.connect("{{ Helper::api_url() }}");
	$(document).on('click','.confirmBtn', function(){
		let url = $(this).attr('data-url');
		let type = $(this).attr('data-type');
		let custom_id = $(this).attr('data-custom_id');
		let txtMsg = '';
		if(type=='travel'){
			  txtMsg = 'Are you sure to travel this mission now?';
			  if(locale=='fr'){
				txtMsg = 'Êtes-vous sûr de voyager cette mission maintenant?';
			  }
			}
		if(type=='arrived'){
			  txtMsg = 'Are you sure to arrive on mission?';
			  if(locale=='fr'){
				txtMsg = "Êtes-vous sûr d'arriver en mission?";
			  }
			}
		if(type=='start'){
			  txtMsg = 'Are you sure to start this mission now?';
			  if(locale=='fr'){
				txtMsg = 'Êtes-vous sûr de commencer cette mission maintenant?';
			  }
			}
		if(type=='finish'){
			  txtMsg = 'Are you sure to finish this mission now?';
			  if(locale=='fr'){
				txtMsg = 'Êtes-vous sûr de terminer cette mission maintenant?';
			  }
			}
		// $(document).find('.confirmation_text').html(txtMsg);
		$(document).find('input[name="custom_id"]').val(custom_id);
		$(document).find('.confirmation_text').html(txtMsg);
		$(document).find('.mission_action_form').attr('name',url);
	});
	$("#general_form_sockit").validate({
		  errorClass   : "has-error",
		  highlight    : function(element, errorClass) {
			$(element).parents('.form-group').addClass(errorClass);
		  },
		  unhighlight  : function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass(errorClass);
		  },
		  rules:{
		  },
		  messages:{
		  },
		  submitHandler: function (form)
		  {
				sockit_request(form);
		  }
    });
	
	function sockit_request(form){
		if(form.name == 'travel-to-mission'){
			socket.emit('custom_travel_to_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}", custom_id: form.custom_id.value});
			location.reload();
		}
		if(form.name == 'arrived-to-mission'){
			socket.emit('custom_arrived_to_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}", custom_id: form.custom_id.value});
			location.reload();
		}
		if(form.name == 'start-mission'){
			socket.emit('custom_start_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}", custom_id: form.custom_id.value});
			location.reload();
		}
		if(form.name == 'finish-mission'){
			socket.emit('custom_finish_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}", custom_id: form.custom_id.value});
			location.reload();
		}
	}	
</script>
@endsection