@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission_requests')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.mission_requests')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
                        <span class="form-control">{{$results->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($results->id)}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$results->location}}</span>
                      </div>
					  @if($results->agent_type)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.type')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($results->agent_type)}}</span>
                      </div>
					  @endif
					  @if($results->total_hours)
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.hours_req')}}</label>
                        <span class="form-control">{{$results->total_hours}}</span>
                      </div>
					  @endif
					  @if($results->agent_count || $results->agents)
					  <div class="col-md-6 form-group">
                        <label>{{__('frontend.mission_request.how_many_agents')}}</label>
                        <span class="form-control">{{ ($results->agent_count) ? $results->agent_count: count($results->agents)}}</span>
                      </div>
					  @endif
					  <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$results->description}}</span>
                      </div>
                    </div>
                  </div>
                </div>
				@if(isset($results->agents))
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>{{__('dashboard.agents.name')}}</th>
                                  <th>From date</th>
                                  <th>To date</th>
                              </tr>
                          </thead>
                          <tbody>
							@php $i = 0; @endphp
							@foreach($results->agents as $result)
							@php $i++; @endphp
								<tr>
								  <td>{{$i}}.</td>
								  <td>{{$result->first_name.' '.$result->last_name}}</td>
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
            </div>
        </div>
        <!-- /.col-md-8 -->
      </div>
    </div>
    <!-- /.container -->
</div>
@endsection