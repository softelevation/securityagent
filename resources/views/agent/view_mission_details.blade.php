@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
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
                        <label>Mission Location</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Agent Type Needed</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Hours</label>
                        <span class="form-control">{{$mission->total_hours}} Hour(s)</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label>Mission Description</label>
                        <p class="">{{$mission->description}}
                          t is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </p>
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
                        <span class="form-control">{{$mission->started_at}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Ended At </label>
                        <span class="form-control">{{$mission->ended_at}}</span>
                      </div>
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-md-12 text-center">
                          @if($mission->status==3)
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/start-mission')}}" data-type="start" class="button success_btn confirmBtn" data-action="1"><i class="fa fa-check"></i> Start Mission</button>
                          @endif
                          @if($mission->status==4)
                            <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/finish-mission')}}" data-type="finish" class="button success_btn confirmBtn" data-action="1"><i class="fa fa-check"></i> Finish Mission</button>
                          @endif
                          @if($mission->status==3 || $mission->status==4)
                            <!-- <button data-toggle="modal" data-target="#mission_action" data-url="{{url('agent/cancel-mission-agent')}}" data-type="cancel_agent" class="button danger_btn confirmBtn" data-action="2"><i class="fa fa-times"></i> Cancel Mission</button> -->
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
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <p class="confirmation_text"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <form id="general_form" class="mission_action_form" method="post" action="" novalidate="novalidate">
          @csrf
          <input type="hidden" name="mission_id" value="{{Helper::encrypt($mission->id)}}">
          <button type="submit" class="btn btn-primary success_btn" >Yes</button>
        </form>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','.confirmBtn', function(){
    let url = $(this).attr('data-url');
    let type = $(this).attr('data-type');
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
    $(document).find('.confirmation_text').html(txtMsg);
    $(document).find('.mission_action_form').attr('action',url);
  });
</script>
@endsection