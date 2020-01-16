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
                        <span class="form-control">{{$mission->agent_type}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Hours</label>
                        <span class="form-control">{{$mission->total_hours}}</span>
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
                    <div class="row">
                      <div class="col-md-12 text-center">
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button success_btn verificationBtn" data-action="1"><i class="fa fa-check"></i> Start Mission</button>
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button danger_btn verificationBtn" data-action="2"><i class="fa fa-times"></i> Reject Mission</button>
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
          <input type="hidden" name="user_id" value="{{Helper::encrypt($mission->user_id)}}">
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