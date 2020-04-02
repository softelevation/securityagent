@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Missions</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>Mission Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Mission Title</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Ref.</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Location</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Agent Type Needed</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Vehicle Required</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Hours</label>
                        <span class="form-control">{{$mission->total_hours}} Hour(s)</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label>Mission Description</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                    </div>
                    @if($mission->status==5)
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Mission Status</label>
                        <span class="form-control">{{Helper::getMissionStatus($mission->status)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Total Hours Taken By Agent </label>
                        <span class="form-control">{{Helper::get_mission_hours($mission->started_at,$mission->ended_at)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Started At</label>
                        <span class="form-control">{{Helper::date_format_show('m/d/Y H:i:s',$mission->started_at)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Ended At </label>
                        <span class="form-control">{{Helper::date_format_show('m/d/Y H:i:s',$mission->ended_at)}}</span>
                      </div>
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-md-12 text-center">
                          @if($mission->status==3)
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/start-mission')}}" data-type="start" class="button success_btn confirmBtn"><i class="fa fa-check"></i> Start Mission</button>
                          @endif
                          @if($mission->status==4)
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/finish-mission')}}" data-type="finish" class="button success_btn confirmBtn"><i class="fa fa-check"></i> Finish Mission</button>
                          @endif
                          @if($mission->status==3 || $mission->status==4)
                            <!-- <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/cancel-mission-agent')}}" data-type="cancel_agent" class="button danger_btn confirmBtn" data-action="2"><i class="fa fa-times"></i> Cancel Mission</button> -->
                          @endif
                          @if($mission->status==0 && $mission->agent_id==Auth::user()->agent_info->id)
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/process-mission-request')}}" data-type="accept" class="button success_btn confirmBtn" data-value="1" data-hours="{{$mission->total_hours}}"><i class="fa fa-check"></i> Accept Mission</button>
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/process-mission-request')}}" data-type="reject" class="button danger_btn confirmBtn" data-value="2"><i class="fa fa-times"></i> Reject Mission</button>
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
        <h4 class="modal-title">Confirm Action</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="general_form" class="mission_action_form" method="post" action="" novalidate="novalidate">
      @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <p class="confirmation_text"></p>
                <input type="hidden" name="mission_id" value="{{Helper::encrypt($mission->id)}}">
                <input id="actionInput" type="hidden" name="action_value">  
                <div class="reject_reason">
                  <div class="form-group">
                    <label>Specify a reason</label>
                    <textarea name="reason" class="form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          @if($mission->total_hours > 12)<button id="12_hrs_btn" type="button" class="btn btn-primary orange_bg">No, Book For 12 Hours</button>@endif
          <button type="submit" class="btn btn-primary success_btn" >Yes</button>
          <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{Form::open(['url'=>url('agent/create-sub-missions'),'id'=>'general_form_2'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->id))}}
{{Form::close()}}
<script>
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
    }
    if(type=='finish'){
      txtMsg = 'Are you sure to finish this mission now?';
    }
    if(type=='cancel_agent'){
      txtMsg = 'Are you sure to cancel this mission now?';
    }
    if(type=='accept'){
      txtMsg = 'Are you sure you want to accept this mission?';
      if(hours > 12){
        txtMsg = 'As this mission exceeds 12 hours so are you sure you want to accept this full mission for '+hours+' hours?';
      }
    }
    if(type=='reject'){
      let reason = $(document).find('#reasonText').val();
      console.log(reason);
      $('#reasonInput').val(reason);
      txtMsg = 'Are you sure you want to reject this mission?';
      $(document).find('.reject_reason').removeClass('d-none');  
    }
    $(document).find('.confirmation_text').html(txtMsg);
    $(document).find('.mission_action_form').attr('action',url);
  });

  // 
  $(document).on('click','#12_hrs_btn',function(){
    $(document).find('#general_form_2').submit();
  });
</script>
@endsection