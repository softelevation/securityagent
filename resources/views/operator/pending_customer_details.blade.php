@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="contact_box">
                <h3>Customer Details</h3>
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
                        <label>Home Address</label>
                        <span class="form-control">{{$data->home_address}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Are you an individual or company ?</label>
                        <span class="form-control">{{Helper::get_customer_type_name($data->customer_type)}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 text-center">
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button success_btn verificationBtn" data-action="1"><i class="fa fa-check"></i> Approve</button>
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button danger_btn verificationBtn" data-action="2"><i class="fa fa-times"></i> Decline</button>

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
<div id="customer_verification_action" class="modal fade" role="dialog">
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
      </div>
      <div class="modal-footer">
        <form id="general_form" method="post" action="{{url('operator/customer_verification')}}" novalidate="novalidate">
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
      $(document).find('.confirm_text').text('Are you sure you want to approve this customer?');
    }else{
      $(document).find('.confirm_text').text('Are you sure you want to decline this customer?');
    }
    $(document).find('#model_action_value').val(action);
  });
</script>
@endsection