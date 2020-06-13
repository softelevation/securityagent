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
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{$mission->total_hours}} {{__('dashboard.hours')}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.type')}}</label>
                        <span class="form-control">@if($mission->quick_book==1) {{__('dashboard.quick_booking')}} @else {{__('dashboard.future_booking')}} @endif</span>
                      </div>
                      @if(isset($mission->start_date_time))
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->start_date_time)}}</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                <h3>{{__('dashboard.agents.available')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <div class="table-responsive">
                          <table class="table table-hover table-striped">
                              <thead>
                                  <tr>
                                    <th>{{__('dashboard.agent')}}</th>
                                    <th>Date</th>
                                    <th>{{__('dashboard.agents.available_from')}}</th>
                                    <th>{{__('dashboard.agents.available_to')}}</th>
                                    <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @forelse($agents as $agent)
                                <tr>
                                  <td>{{$agent->username}}</td>
                                  <td>@if($agent->schedule->count() > 0) {{Helper::date_format_show('d/m/Y', $agent->schedule[0]->schedule_date)}} @else {{__('dashboard.not_set')}} @endif</td>
                                  <td>@if($agent->schedule->count() > 0) {{$agent->schedule[0]->available_from}} @else {{__('dashboard.not_set')}} @endif</td>
                                  <td>@if($agent->schedule->count() > 0) {{$agent->schedule[0]->available_to}} @else {{__('dashboard.not_set')}} @endif</td>
                                  <td><a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" class="action_icons day_on book_agent_later"><i class="fa fa-user-plus"></i> {{__('dashboard.assign')}}</a></td>
                                </tr>
                                @empty
                                <tr>
                                  <td colspan="9">{{__('dashboard.no_record')}}</td>
                                </tr>
                                @endforelse
                              </tbody>
                          </table>
                        </div>
                      </div>
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
{{Form::open(['url'=>url('operator/book-agent-later-mission'),'id'=>'general_form'])}}
{{Form::hidden('agent_id',null,['id'=>'agent_book_later_mission'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->id))}}
{{Form::close()}}
@endsection