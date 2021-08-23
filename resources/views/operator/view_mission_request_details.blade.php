@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.missions')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.mission.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agent_needed')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.vehicle_required')}}</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{($mission->total_hours) ? date('H:i', strtotime($mission->total_hours)):'N/A'}} {{__('dashboard.hours')}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.customer_name')}}</label>
                        <span class="form-control">{{ucfirst($mission->customer->first_name.' '.$mission->customer->last_name)}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('frontend.mission_request.how_many_agents')}}</label>
                        <span class="form-control">{{($mission->agent_count) ? $mission->agent_count:'N/A'}}</span>
                      </div>
                      @if(isset($mission->start_date_time) && $mission->start_date_time!='')
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{$mission->start_date_time}}</span>
                      </div>
                      @endif
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.payment_status')}}</label>
                        <span class="form-control">{{($mission->payment_status) ? 'Paid': 'Not paid'}}</span>
                      </div>
                      <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                    </div>
                  </div>
                </div>
				
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
					{{Form::open(['url'=>url('operator/sand-custom-request/'.$mission_id),'id'=>'general_form'])}}
					@if(!$mission->payment_status)
					@if(empty($mission->assign_agents))
                    <div class="row custom-mission-request custom-mission-0">
                      <div class="col-md-3 form-group">
                        <label>{{__('dashboard.agents.name')}}</label>
						<select name="agent_type[]" class="form-control">
								<option value="">{{__('frontend.select')}}</option>
								@foreach($agents as $agent)
									<option value="{{$agent->id}}" data-agent_type="{{$agent->agent_type}}">{{$agent->username}}</option>
								@endforeach
						  </select>
                      </div>
                      <div class="col-md-3 form-group">
                        <label>From date</label>
                        <input class="form-control datetimepicker" placeholder="Date Time" name="start_date_time[]" type="text" autocomplete="off">
                      </div>
					  <div class="col-md-3 form-group">
                        <label>To date</label>
                        <input class="form-control datetimepicker" id="end_date_time_0" placeholder="Date Time" name="end_date_time[]" type="text" autocomplete="off">
                      </div>
					  <div class="col-md-2 form-group">
                        <label>{{__('dashboard.amount')}}</label>
						<input class="form-control" placeholder="{{__('dashboard.amount')}}" id="amount" name="amount[]" type="text">
                      </div>
					  <div class="col-md-1 plus-action_icons">
                        <label>Action</label>
						<p class="action_icons"><i class="fas fa-plus-circle custom-mission-request" aria-hidden="true"></i></p>
                      </div>
                    </div>
					@else
						@foreach($mission->assign_agents as $keys => $assign_agent)
						@if(!$keys)
							<div class="row custom-mission-request custom-mission-{{$keys}}">
						@else
							<div class="row custom-mission-{{$keys}}">
						@endif
						  <div class="col-md-3 form-group">
							@if(!$keys)<label>{{__('dashboard.agents.name')}}</label>@endif
							<select name="agent_type[]" class="form-control">
									<option value="">{{__('frontend.select')}}</option>
									@foreach($agents as $agent)
										<option value="{{$agent->id}}" data-agent_type="{{$agent->agent_type}}" @if($assign_agent->agent_id == $agent->id) selected @endif>{{$agent->username}}</option>
									@endforeach
							  </select>
						  </div>
						  <div class="col-md-3 form-group">
							@if(!$keys)<label>From date</label>@endif
							<input class="form-control datetimepicker" value="{{$assign_agent->start_date_time}}" placeholder="Date Time" name="start_date_time[]" type="text" autocomplete="off">
						  </div>
						  <div class="col-md-3 form-group">
							@if(!$keys)<label>To date</label>@endif
							<input class="form-control datetimepicker" id="end_date_time_{{$keys}}" value="{{$assign_agent->end_date_time}}" placeholder="Date Time" name="end_date_time[]" type="text" autocomplete="off">
						  </div>
						  <div class="col-md-2 form-group">
							@if(!$keys)<label>{{__('dashboard.amount')}}</label>@endif
							<input class="form-control" value="{{($assign_agent->amount) ? $assign_agent->amount : 0}}" id="amount" placeholder="{{__('dashboard.amount')}}" name="amount[]" type="text">
						  </div>
						  @if(!$keys)
						  <div class="col-md-1 plus-action_icons">
							<label>Action</label>
							<p class="action_icons"><i class="fas fa-plus-circle custom-mission-request" aria-hidden="true"></i></p>
						  </div>
						  @else
							<div class="col-md-1"><p class="action_icons"><i class="fa fa-minus-circle custom-mission-request" aria-hidden="true"></i></p></div>
						  @endif
						</div>
						@endforeach
					@endif
					@else
						@foreach($mission->assign_agents as $keys => $assign_agent)
						<div class="row custom-mission-request custom-mission-{{$keys}}">
						  <div class="col-md-4 form-group">
							@if(!$keys)<label>{{__('dashboard.agents.name')}}</label>@endif
							<select name="agent_type[]" class="form-control" disabled>
									<option value="">{{__('frontend.select')}}</option>
									@foreach($agents as $agent)
										<option value="{{$agent->id}}" data-agent_type="{{$agent->agent_type}}" @if($assign_agent->agent_id == $agent->id) selected @endif>{{$agent->username}}</option>
									@endforeach
							  </select>
						  </div>
						  <div class="col-md-3 form-group">
							@if(!$keys)<label>From date</label>@endif
							<input class="form-control datetimepicker" value="{{$assign_agent->start_date_time}}" placeholder="Date Time" name="start_date_time[]" type="text" disabled>
						  </div>
						  <div class="col-md-3 form-group">
							@if(!$keys)<label>To date</label>@endif
							<input class="form-control datetimepicker" id="end_date_time_{{$keys}}" value="{{$assign_agent->end_date_time}}" placeholder="Date Time" name="end_date_time[]" type="text" disabled>
						  </div>
						  <div class="col-md-2 form-group">
							@if(!$keys)<label>{{__('dashboard.amount')}}</label>@endif
							<input class="form-control" value="{{($assign_agent->amount) ? $assign_agent->amount : 0}}" id="amount" placeholder="{{__('dashboard.amount')}}" name="amount[]" type="text" disabled>
						  </div>
						</div>
						@endforeach
					@endif
					<div class="row">
							<div class="col-md-12 text-center">
								  @if(!$mission->payment_status)
									<button type="submit" name="action_button" class="button success_btn" value="request_for_payment">{{__('dashboard.agents.request_for_payment')}} -(<span id="process_to_paid">{{$mission->amount}}</span>)</button>
								  @else
									  @if($mission->status == '1')
										<button type="submit" name="action_button" class="button success_btn" value="assign">{{__('dashboard.assign')}}</button>
									  @endif
								  @endif
							</div>
					</div>
					{{Form::close()}}
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
@endsection