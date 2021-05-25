@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">

      @if ( session()->has('message_success'))
          <div class="alert alert-info" role="alert">
              <a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>
              {{ session()->get('message_success') }}
          </div>
      @endif

        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.message_center')}}</h2>
              </div>
			  <form>
                    <div class="col-md-3  float-left form-group">
                        <select class="form-control" name="message_center_status"> 
                                <option value="" disabled="" selected="">Search message by :</option>
                                <option value="customers" <?php echo ($_GET['action'] == 'customers') ? 'selected':''; ?>>{{__('dashboard.customers')}}</option>
                                <option value="agents" <?php echo ($_GET['action'] == 'agents') ? 'selected':''; ?>>{{__('dashboard.agents.agents')}}</option>
                        </select>
                    </div>
					</form>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.payment.message_center_heading')}} </a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- Pending Agents -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('dashboard.mission.mission')}}</th>
                                    <th>{{__('dashboard.from')}}</th>
                                    <th>{{__('dashboard.billings.date_time')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($message_center as $message)
                                <tr>
                                    <td>{{$message->first_name.' '.$message->last_name}}</td>
                                    <td>@if($message->message_type=='send_by_cus') {{__('dashboard.customer')}} @elseif($message->message_type=='send_by_op') {{__('dashboard.operator')}} @else {{__('dashboard.agent')}} @endif</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($message->created_at))}}</td>
                                    <td><a href="{{url('operator/message-center')}}/{{ Helper::encrypt($message->user_id) }}?action={{$_GET['action']}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>@if(Helper::get_message_center_from_user($message->user_id) > 0)<span class="badge badge-primary badge-pill float-right orange_bg">{{Helper::get_message_center_from_user($message->user_id)}}</span>@endif</td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
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
{{Form::open(['url'=>url('operator/block-unblock-agent'),'id'=>'general_form'])}}
{{Form::hidden('agent_id',null,['id'=>'agent_id'])}}
{{Form::hidden('type',null,['id'=>'type'])}}
{{Form::close()}}
@endsection

@section('script')
<script>
	// var mission_id = 0;
	// <select class="form-control" name="message_center_status"> 
	$('select[name="message_center_status"]').click(function(){	
		let action_val = $(this).val();
		console.log(action_val);
		window.location.href = 'message-center?action='+action_val; 
		// location.reload('http://127.0.0.1:8000/operator/message-center?action='+action_val);
		// 
	});
	
</script>
@endsection
