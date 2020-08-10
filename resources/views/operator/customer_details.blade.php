@extends('layouts.dashboard')
@section('content')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider_bank {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider_bank:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider_bank {
  background-color: #d6fb04;
}

input:focus + .slider_bank {
  box-shadow: 0 0 1px #d6fb04;
}

input:checked + .slider_bank:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider_bank.round {
  border-radius: 34px;
}

.slider_bank.round:before {
  border-radius: 50%;
}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.customers')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.customer_details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_127')}}</label>
                        <span class="form-control">{{$data->first_name}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_129')}}</label>
                        <span class="form-control">{{$data->last_name}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_131')}}</label>
                        <span class="form-control">{{$data->user->email}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_133')}}</label>
                        <span class="form-control">{{$data->phone}}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_139')}}</label>
                        <span class="form-control">{{$data->home_address}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('frontend.text_141')}}</label>
                        <span class="form-control">{{Helper::get_customer_type_name($data->customer_type)}}</span>
                      </div>
                    </div>
					@if($data->customer_type == '2')
					<div class="row">
                      <div class="col-md-6 form-group">
					   <label>{{__('frontend.text_154')}}</label><br/>
							<label class="switch">
							  <input type="checkbox" name="bank_transfer" data-status="cus_detail" value="{{$data->id}}" @if($data->add_bank == '1') checked @endIf>
							  <span class="slider_bank round"></span>
							</label>
                      </div>
                    </div>
					@endIf
<!--                     <div class="row">
                      <div class="col-md-12 text-center">
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button success_btn verificationBtn" data-action="1"><i class="fa fa-check"></i> Approve</button>
                          <button data-toggle="modal" data-target="#customer_verification_action" class="button danger_btn verificationBtn" data-action="2"><i class="fa fa-times"></i> Decline</button>

                      </div>
                    </div> -->
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
<!-- <script>
  $(document).on('click','.verificationBtn', function(){
    let action = $(this).attr('data-action');
    if(action==1){
      $(document).find('.confirm_text').text('Are you sure you want to approve this customer?');
    }else{
      $(document).find('.confirm_text').text('Are you sure you want to decline this customer?');
    }
    $(document).find('#model_action_value').val(action);
  });
</script> -->
@endsection