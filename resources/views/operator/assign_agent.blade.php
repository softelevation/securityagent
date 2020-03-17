@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Missions</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
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
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Hours</label>
                        <span class="form-control">{{$mission->total_hours}} Hour(s)</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Start Datetme</label>
                        <span class="form-control">{{date('m/d/Y H:i:s', strtotime($mission->start_date_time))}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <h3>Agents Available</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <div class="table-responsive">
                          <table class="table table-hover table-striped">
                              <thead>
                                  <tr>
                                    <th>Agent</th>
                                    <th>Sunday</th>
                                    <th>Monday</th>
                                    <th>Tuesday</th>
                                    <th>Wednesday</th>
                                    <th>Thursday</th>
                                    <th>Friday</th>
                                    <th>Saturday</th>
                                    <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @forelse($agents as $agent)
                                <tr style="font-size: 12px;">
                                  <td>{{$agent->username}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->sunday_from))}} - {{date('H:i', strtotime($agent->schedule->sunday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->monday_from))}} - {{date('H:i', strtotime($agent->schedule->monday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->tuesday_from))}} - {{date('H:i', strtotime($agent->schedule->tuesday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->wednesday_from))}} - {{date('H:i', strtotime($agent->schedule->wednesday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->thursday_from))}} - {{date('H:i', strtotime($agent->schedule->thursday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->friday_from))}} - {{date('H:i', strtotime($agent->schedule->friday_to))}}</td>
                                  <td>{{date('H:i', strtotime($agent->schedule->saturday_from))}} - {{date('H:i', strtotime($agent->schedule->saturday_to))}}</td>
                                  <td><a href="javascript:void(0)" id="{{Helper::encrypt($agent->id)}}" class="action_icons day_on book_agent_later"><i class="fa fa-user-plus"></i> Assign</a></td>
                                </tr>
                                @empty
                                <tr style="font-size: 12px;">
                                  <td colspan="9">No Agent Available</td>
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