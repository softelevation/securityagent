@extends('layouts.dashboard')
@section('content')
<style>
div.ex1 {background-color: lightblue; height: 325px; overflow: scroll; padding: 10px;}
.yellow_btn{box-shadow: none; height: 40px; line-height: 40px}
.send_by_agent{float: right;position: relative;margin-left: 50%;max-width: 50%;}
.send_by_op{float: left; width: 100%;}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
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
                          <a class="nav-link active">{{__('dashboard.agent_support')}} </a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    <div class="message-center-cont">
                          <div class="table-responsive">
                              <div class="ex1 message-center-child">
								@foreach($user_messages as $user_message)
								  <?php
									if($user_message->message_type === 'send_by_agent'){
										$fullname = ($cus_profile) ? ucfirst($cus_profile->first_name).' '.ucfirst($cus_profile->last_name) : 'Unknown';
									}else{
										$fullname = ($operator_profile) ? ucfirst($operator_profile->first_name).' '.ucfirst($operator_profile->last_name) : 'Unknown';
									}
								  ?>
									<p class="{{$user_message->message_type}}"><b>{{$fullname}} :</b>{{$user_message->message}}</p>
								  @endforeach
								<div class="message_last"></div>
							  </div>
							  
							
						  
                          </div>
						  <div class="view_agent_details mt-4">
								<div class="row">
									<div class="col-md-8 form-group">
									  {{Form::textarea('send_message',null,['data-id'=>$user_id,'data-cus_id'=>$cus_id,'class'=>'form-control message-center','placeholder'=>__('frontend.text_152')])}}
									</div>
									<div class="col-md-4 ">
										<input type="submit" class="yellow_btn" value="{{__('frontend.text_73')}}"/>
									</div>
								</div>
							</div>
						  
                      </div>
                    <!-- Missions in progress tab -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-md-8 -->
        </div>

    </div>
    <!-- /.container -->
</div>
@endsection

@section('script')
<script src="{{ Helper::api_url('socket.io/socket.io.js') }}"></script>
<script>
	$('.message-center-child').scrollTop($('.message-center-child')[0].scrollHeight);
	var cus_id = {{$cus_id}};
	// console.log(cus_id);
	let socket = io.connect("{{ Helper::api_url() }}");
	
	socket.on('refresh_feed_'+cus_id,function(msg){
		if(msg){
			location.reload();
		}
	});
	
	$('input[type="submit"]').click(function(event){
		let send_message = $('textarea[name="send_message"]').val();
		socket.emit('message_center',{
			mission_id:0,
			token:"{{Auth::user()->token}}",
			message:send_message
		});
		location.reload();
		
	});
</script>
@endsection