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
                        <span class="form-control">{{$mission->mission->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->mission->id)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$mission->mission->location}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agent_needed')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.vehicle_required')}}</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{$mission->mission->total_hours}} {{__('dashboard.hours')}}</span>
                      </div>
					  <div class="col-md-12 form-group">
                        <label>{{__('dashboard.agents.intervention')}}</label>
                        <span class="form-control">{{__('dashboard.agents.'.$mission->mission->intervention.'')}}</span>
                      </div>
					  @if($mission->mission->intervention == 'Security_patrol' && isset($mission->mission->repetitive_mission) && isset($mission->mission->mission_finish_time) && !empty($mission->mission->repetitive_mission) && !empty($mission->mission->mission_finish_time))
						<div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.repetitive_mission')}}</label>
                        <span class="form-control">{{__('dashboard.agents.'.str_replace(" ","_",$mission->mission->repetitive_mission).'')}}</span>
                      </div>
					  <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.finish_time')}}</label>
                        <span class="form-control">{{$mission->mission->mission_finish_time}}</span>
                      </div>
					  <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.time_intervel')}}</label>
                        <span class="form-control">{{$mission->mission->time_intervel}} {{__('dashboard.hours')}}</span>
                      </div>
					  @endif
                      @if(isset($mission->mission->start_date_time) && $mission->mission->start_date_time!="")
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->mission->start_date_time)}}</span>
                      </div>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$mission->mission->description}}</span>
                      </div>
                    </div>
                    @if($mission->mission->status==5)
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_status')}}</label>
                        <span class="form-control">{{Helper::getMissionStatus($mission->mission->status)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.hours_taken')}}</label>
                        <span class="form-control">{{Helper::get_mission_hours($mission->mission->started_at,$mission->mission->ended_at)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.started_at')}}</label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->mission->started_at)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ended_at')}}</label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->mission->ended_at)}}</span>
                      </div>
                    </div>
                    @endif
                    <div class="row">
                     <div class="col-md-12 text-center">
                          @if($mission->mission->status==3)
                            <button data-toggle="modal" data-target="#mission_action" data-url="start-mission" data-type="start" class="button success_btn confirmBtn"><i class="fa fa-check"></i> {{__('dashboard.mission.start_mission')}}</button>
                          @endif
                          @if($mission->mission->status==4)
                            <button data-toggle="modal" data-target="#mission_action" data-url="finish-mission" data-type="finish" class="button success_btn confirmBtn"><i class="fa fa-check"></i> {{__('dashboard.mission.finish_mission')}}</button>
                          @endif
                          @if($mission->mission->status==3 || $mission->mission->status==4)
                            <!-- <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/cancel-mission-agent')}}" data-type="cancel_agent" class="button danger_btn confirmBtn" data-action="2"><i class="fa fa-times"></i> Cancel Mission</button> -->
                          @endif
                          @if($mission->mission->status==0 && $mission->mission->agent_id==Auth::user()->agent_info->id)
                            <button data-toggle="modal" data-target="#mission_action" data-url="process-mission-request" data-type="accept" class="button success_btn confirmBtn" data-value="1" data-hours="{{$mission->mission->total_hours}}"><i class="fa fa-check"></i> {{__('dashboard.mission.accept_mission')}}</button>
                            <button data-toggle="modal" data-target="#mission_action" data-url="process-mission-request" data-type="reject" class="button danger_btn confirmBtn" data-value="2"><i class="fa fa-times"></i> {{__('dashboard.mission.reject_mission')}}</button>
                          @endif
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
                <input type="hidden" name="mission_id" value="{{$mission->mission->id}}">
                <input id="actionInput" type="hidden" name="action_value">  
                <div class="reject_reason">
                  <div class="form-group">
                    <label>{{__('dashboard.specify_reason')}}</label>
                    <textarea name="reason" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          @if($mission->mission->total_hours > 12)<button id="12_hrs_btn" type="button" class="btn btn-primary orange_bg">{!!__('dashboard.book_12_hours')!!}</button>@endif
          <button type="submit" class="btn btn-primary success_btn" >{{__('dashboard.yes')}}</button>
          <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">{{__('dashboard.close')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{Form::open(['url'=>url('agent/create-sub-missions'),'id'=>'general_form_2'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->mission->id))}}
{{Form::close()}}
@endsection

@section('script')
<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
<script>
  var locale = '@php echo app()->getLocale(); @endphp';
  $(document).on('click','.confirmBtn', function(){
    $(document).find('.reject_reason').addClass('d-none');
    let url = $(this).attr('data-url');
    let type = $(this).attr('data-type');
    let value = $(this).attr('data-value');
    let hours = $(this).attr('data-hours');
    $('#actionInput').val(value);
    var txtMsg = '';
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
    if(type=='cancel_agent'){
      txtMsg = 'Are you sure to cancel this mission now?';
      if(locale=='fr'){
        txtMsg = "Êtes-vous sûr d'annuler cette mission maintenant?";
      }
    }
    if(type=='accept'){
      txtMsg = 'Are you sure you want to accept this mission?';
      if(locale=='fr'){
        txtMsg = "Êtes-vous sûr de vouloir accepter cette mission?";
      }

      if(hours > 12){
        txtMsg = 'As this mission exceeds 12 hours so are you sure you want to accept this full mission for '+hours+' hours?';
        if(locale=='fr'){
          txtMsg = "Comme cette mission dépasse 12 heures, êtes-vous sûr de vouloir accepter cette mission complète pendant "+hours+" heures?";
        }
      }
    }
    if(type=='reject'){
      let reason = $(document).find('#reasonText').val();
      console.log(reason);
      $('#reasonInput').val(reason);
      txtMsg = 'Are you sure you want to reject this mission?';
      if(locale=='fr'){
        txtMsg = "Êtes-vous sûr de vouloir rejeter cette mission?";
      }
      $(document).find('.reject_reason').removeClass('d-none');  
    }
    $(document).find('.confirmation_text').html(txtMsg);
    $(document).find('.mission_action_form').attr('name',url);
    $(document).find('.mission_action_form').attr('action',url);
  });

  // 
  $(document).on('click','#12_hrs_btn',function(){
    $(document).find('#general_form_2').submit();
  });
  
	let socket = io.connect("{{ Helper::api_url() }}");
  
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
		  // console.log('general_form_sockit');
			sockit_request(form);
      }
    });
	
	function sockit_request(form){
		if(form.name == 'process-mission-request'){
			socket.emit('agent_mission_request',{
				mission_id:form.mission_id.value,
				status:form.action_value.value
			});
			location.reload();
		}
		if(form.name == 'start-mission'){
			socket.emit('start_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}"});
			location.reload();
		}
		if(form.name == 'finish-mission'){
			let mission_id = '{{ url("/agent/report") }}/'+"{{Helper::encrypt('"+form.mission_id.value+"')}}";
			socket.emit('finish_mission',{mission_id: form.mission_id.value, token: "{{Auth::user()->token}}"});
			window.location.href = mission_id;
		}
		
		// console.log(form.name);
		// console.log(form.mission_id.value);
		// console.log(form.action_value.value);
		// console.log(form.reason.value);
	}
	
</script>
@endsection