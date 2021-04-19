@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.agents.agents')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.first_name')}}</label>
                        <span class="form-control">{{$data->first_name}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.last_name')}}</label>
                        <span class="form-control">{{$data->last_name}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_99')}}</label>
                        <span class="form-control">{{$data->email}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.phone_number')}}</label>
                        <span class="form-control">{{$data->phone}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_103')}}</label>
                        <span class="form-control">{{$data->identity_card}} <a class="action_icons" title="Download" href="{{Helper::api_url($data->identity_card)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_105')}}</label>
                        <span class="form-control">{{$data->social_security_number}} <a class="action_icons" title="Download" href="{{Helper::api_url($data->social_security_number)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_107')}}</label>
                        <span class="form-control">{{$data->cv}} <a class="action_icons" title="Download" href="{{Helper::api_url($data->cv)}}" target="_blank"><i class="fa fa-download"></i></a></span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_109')}}</label>
                        <span class="form-control">{{$data->iban}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_111')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name_multiple($data->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_113')}}</label>
                        <span class="form-control">@if(empty($data->cnaps_number)) N/A @else {{$data->cnaps_number}} @endif</span>
                      </div>
                    </div>
                    @if($data->status==0)
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <button data-toggle="modal" data-target="#agent_verification_action" class="button success_btn verificationBtn" data-action="1"><i class="fa fa-check"></i> {{__('dashboard.approve')}}</button>
                        <button data-toggle="modal" data-target="#agent_verification_action" class="button danger_btn verificationBtn" data-action="2"><i class="fa fa-times"></i> {{__('dashboard.decline')}}</button>
                      </div>
                    </div>
                    @endif
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
          <button type="submit" class="btn btn-primary success_btn" >{{__('dashboard.yes')}}</button>
        </form>
        <button type="button" class="btn btn-secondary danger_btn"  data-dismiss="modal">{{__('dashboard.close')}}</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click','.verificationBtn', function(){
    let action = $(this).attr('data-action');
    if(action==1){
      $(document).find('.confirm_text').text("{{__('dashboard.agent_approve_confirm')}}");
    }else{
      $(document).find('.confirm_text').text("{{__('dashboard.agent_decline_confirm')}}");
    }
    $(document).find('#model_action_value').val(action);
  });
</script>
@endsection