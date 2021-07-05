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
                        <span class="form-control">{{$mission->agent_type}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.vehicle_required')}}</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{$mission->total_hours}} {{__('dashboard.hours')}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.customer_name')}}</label>
                        <span class="form-control">{{ucfirst($mission->customer->first_name.' '.$mission->customer->last_name)}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.intervention')}}</label>
                        <span class="form-control">{{__('dashboard.agents.'.$mission->intervention.'')}}</span>
                      </div>
                      @if(isset($mission->start_date_time) && $mission->start_date_time!='')
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}}</span>
                      </div>
                      @endif
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
					{{Form::open(['url'=>url('operator/sand-custom-request/'.$mission->id),'id'=>'general_form'])}}
                    <div class="row custom-mission-request">
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.name')}}</label>
						<select name="agent_type[]" class="form-control">
								<option value="">{{__('frontend.select')}}</option>
								@foreach($agents as $agent)
									<option value="{{$agent->id}}">{{$agent->username}}</option>
								@endforeach
						  </select>
                      </div>
                      <div class="col-md-3 form-group">
                        <label>From date</label>
                        <input class="form-control datetimepicker" placeholder="Date Time" name="start_date_time[]" type="text">
                      </div>
					  <div class="col-md-3 form-group">
                        <label>To date</label>
                        <input class="form-control datetimepicker" placeholder="Date Time" name="end_date_time[]" type="text">
                      </div>
					  <div class="col-md-2 plus-action_icons">
                        <label>Action</label>
						<p class="action_icons"><i class="fas fa-plus-circle custom-mission-request" aria-hidden="true"></i></p>
                      </div>
                    </div>
					<div class="row">
							<div class="col-md-12 text-center">
                                  <button type="submit" class="button success_btn">{{__('dashboard.agents.assign')}}</button>
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