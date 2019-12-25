@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3>Agent Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <span class="form-control">{{$data->first_name}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <span class="form-control">{{$data->last_name}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Email Address</label>
                        <span class="form-control">{{$data->user->email}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Phone</label>
                        <span class="form-control">{{$data->phone}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Identity Card Document</label>
                        <span class="form-control">{{$data->identity_card}} <a class="action_icons" title="Download" href="{{asset('agent/documents/'.$data->identity_card)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Social Security Number Document</label>
                        <span class="form-control">{{$data->social_security_number}} <a class="action_icons" title="Download" href="{{asset('agent/documents/'.$data->social_security_number)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Curriculum Vitae</label>
                        <span class="form-control">{{$data->cv}} <a class="action_icons" title="Download" href="{{asset('agent/documents/'.$data->cv)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>IBAN Info</label>
                        <span class="form-control">{{$data->iban}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Agent Type</label>
                        <span class="form-control">{{Helper::get_agent_type_name_multiple($data->types)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>CNAPS Number</label>
                        <span class="form-control">@if(empty($data->cnaps_number)) N/A @else {{$data->cnaps_number}} @endif</span>
                      </div>
                    </div>
                    @if($data->agent_type == 1 || $data->agent_type == 2 || $data->agent_type == 3)
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Diploma Certificates</label>
                        @foreach($data->diploma_certificates as $certificate)
                          <span class="form-control">{{$certificate->file_name}} <a class="action_icons" title="Download" href="{{asset('agent/documents/'.$certificate->file_name)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Home Address</label>
                        <span class="form-control">{{$data->home_address}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Work Location</label>
                        <span class="form-control">{{$data->work_location_address}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Do you have a vehicle to do the missions ?</label>
                        <span class="form-control">@if($data->is_vehicle==1) Yes @else No @endif</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                          <button data-toggle="modal" data-target="#agent_verification_action" class="button success_btn verificationBtn" data-action="1"><i class="fa fa-check"></i> Approve</button>
                          <button data-toggle="modal" data-target="#agent_verification_action" class="button danger_btn verificationBtn" data-action="2"><i class="fa fa-times"></i> Decline</button>

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
<div id="agent_verification_action" class="modal fade" role="dialog">
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
              <p class="confirm_text"></p>
            </div>
          </div>
        </div>
        <!-- <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Message</label>
              <textarea class="form-control" placeholder="Enter Your Message"></textarea>
            </div>
          </div>
        </div> -->
        <!-- <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <input type="submit" class="yellow_btn" value="Become Agent"/>
            </div>
          </div>
        </div> -->          
      </div>
      <div class="modal-footer">
        <form id="general_form" method="post" action="{{url('operator/agent_verification')}}" novalidate="novalidate">
          @csrf
          <input id="model_action_value" type="hidden" name="verify_status">
          <input type="hidden" name="user_id" value="{{Helper::encrypt($data->user_id)}}">
          <button type="submit" class="btn btn-primary success_btn" >Yes</button>
        </form>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','.verificationBtn', function(){
    let action = $(this).attr('data-action');
    if(action==1){
      $(document).find('.confirm_text').text('Are you sure you want to approve this agent?');
    }else{
      $(document).find('.confirm_text').text('Are you sure you want to decline this agent?');
    }
    $(document).find('#model_action_value').val(action);
  });
</script>
@endsection