@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
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
					  @if($mission->agent_type)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.type')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
					  @endif
					  @if($mission->total_hours)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.hours_req')}}</label>
                        <span class="form-control">{{$mission->total_hours}}</span>
                      </div>
					  @endif
					  @if($mission->agent_count || $mission->agent)
					  <div class="col-md-6 form-group">
                        <label>{{__('frontend.mission_request.how_many_agents')}}</label>
                        <span class="form-control">{{ ($mission->agent_count) ? $mission->agent_count: count($mission->agent)}}</span>
                      </div>
					  @endif
					  <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                </div>
              </div>
            </div>
			@if(isset($mission->agent))
			<h3>{{__('dashboard.agents.schedule')}}</h3>
			<div class="pending-details">
			  <div class="view_agent_details mt-4">
				<div class="table-responsive">
					<table class="table table-hover table-striped">
					  <thead>
						  <tr>
							  <th>#</th>
							  <th>From date</th>
							  <th>To date</th>
						  </tr>
					  </thead>
					  <tbody>
						@php $i = 0; @endphp
						@foreach($mission->agent as $result)
						@php $i++; @endphp
							<tr>
							  <td>{{$i}}.</td>
							  <td>{{$result->start_date_time}}</td>
							  <td>{{$result->end_date_time}}</td>
							</tr>
						@endforeach
					  </tbody>
					</table>
				</div>
			  </div>
			</div>
			@endif
          </div>
            <!-- /.col-md-8 -->
        </div>

    </div>
    <!-- /.container -->
</div>
{{Form::open(['url'=>url('agent/create-sub-missions'),'id'=>'general_form_2'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->id))}}
{{Form::close()}}
@endsection