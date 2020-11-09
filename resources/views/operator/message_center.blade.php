@extends('layouts.dashboard')
@section('content')
<style>
div.ex1 {background-color: lightblue; height: 325px; overflow: scroll; padding: 10px;}
.yellow_btn{box-shadow: none; height: 40px; line-height: 40px}
.send_by_cus{float: left; width: 100%;}
.send_by_agent{float: left; width: 100%;}
.send_by_op{float: right;position: relative;margin-left: 50%;max-width: 50%;}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.message_center')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.customer_support')}} </a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                      <div class="message-center-cont">
                          <div class="table-responsive">
                              <div class="ex1 message-center-child">
								  @foreach($user_messages as $user_message)
								  <?php
									if($user_message->message_type === 'send_by_op'){
										$fullname = ($opData) ? ucfirst($opData->first_name).' '.ucfirst($opData->last_name) : 'Unknown';
									}else{
										$fullname = ($user_message) ? ucfirst($user_message->first_name).' '.ucfirst($user_message->last_name) : 'Unknown';
									}
								  ?>
									<p class="{{$user_message->message_type}}"><b>{{$fullname}} :</b>{{$user_message->message}}</p>
								  @endforeach
									<div class="message_last"></div>
							  </div>
						
                          </div>
						  <div class="view_agent_details mt-4">
								{{Form::model($profile,['url'=>url('operator/message-center'),'id'=>'message_center'])}}
								  <div class="row">
									<div class="col-md-8 form-group">
									  {{Form::textarea('send_message',null,['data-id'=>$user_id,'data-cus_id'=>$cus_id,'class'=>'form-control message-center','placeholder'=>__('frontend.text_152')])}}
									</div>
									<div class="col-md-4 ">
										<input type="submit" class="yellow_btn" value="{{__('frontend.text_73')}}"/>
									</div>
								  </div>
								  {{Form::close()}}
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
{{Form::open(['url'=>url('operator/process-refund-request'),'id'=>'general_form'])}}
{{Form::hidden('record_id',null,['id'=>'record_id'])}}
{{Form::hidden('refund_status',null,['id'=>'refund_status'])}}
{{Form::close()}}
@endsection

@section('script')
<script>
	$('.message-center-child').scrollTop($('.message-center-child')[0].scrollHeight);
</script>
@endsection