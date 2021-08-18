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
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-25">
                          <a id="nav-all-mission-tab" data-toggle="tab" href="#nav-mission-all" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='all') active @endif">{{__('dashboard.all_mission_requests')}} </a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-in-progress-tab" data-toggle="tab" href="#nav-mission-in-progress" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='inprogress') active @endif">{{__('dashboard.mission.in_progress')}}</a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-mission-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='pending') active @endif">{{__('dashboard.mission.pending')}}</a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-finished-tab" data-toggle="tab" href="#nav-mission-finished" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='finished') active @endif">{{__('dashboard.mission.finished')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    <div class="tab-pane fade show @if($page_name=='all') active @endif" id="nav-mission-all" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
									  <th>#</th>
									  <th>{{__('dashboard.mission.title')}}</th>
									  <th>{{__('dashboard.mission.location')}}</th>
									  <th>{{__('dashboard.mission.hours_req')}}</th>
									  <th>{{__('dashboard.mission.started_at')}}</th>
									  <th>{{__('dashboard.action')}}</th>
								  </tr>
                            </thead>
                            <tbody>
								@foreach($results as $key => $result)
								  <tr>
									  <td>{{$key+1}}.</td>
									  <td>{{$result->title}}</td>
									  <td>{{$result->location}}</td>
									  <td>{{($result->total_hours) ? date('H:i', strtotime($result->total_hours)):'N/A'}}</td>
									  <td>{{($result->start_date_time) ? $result->start_date_time:'N/A'}}</td>
									  <td><p><a href="{{url('customer/mission-requests/view')}}/{{Helper::encrypt($result->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
								  </tr>
								@endforeach
							  </tbody>
                        </table>
                      </div>
                      
                    </div>
                    <!-- Missions in progress tab -->
                   <div class="tab-pane fade show @if($page_name=='inprogress') active @endif" id="nav-mission-in-progress" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
							  <tr>
								  <th>#</th>
								  <th>{{__('dashboard.mission.title')}}</th>
								  <th>{{__('dashboard.mission.location')}}</th>
								  <th>{{__('dashboard.mission.hours_req')}}</th>
								  <th>{{__('dashboard.mission.started_at')}}</th>
								  <th>{{__('dashboard.action')}}</th>
							  </tr>
						  </thead>
                            <tbody>
							@foreach($missionPending as $key => $result)
							  <tr>
								  <td>{{$key+1}}.</td>
								  <td>{{$result->title}}</td>
								  <td>{{$result->location}}</td>
								  <td>{{($result->total_hours) ? date('H:i', strtotime($result->total_hours)):'N/A'}}</td>
								  <td>{{($result->start_date_time) ? $result->start_date_time:'N/A'}}</td>
								  <td><p><a href="{{url('customer/mission-requests/view')}}/{{Helper::encrypt($result->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
							  </tr>
							@endforeach
						  </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- Missions pending tab -->
                    <div class="tab-pane fade show @if($page_name=='pending') active @endif" id="nav-mission-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
								  <tr>
									  <th>#</th>
									  <th>{{__('dashboard.mission.title')}}</th>
									  <th>{{__('dashboard.mission.location')}}</th>
									  <th>{{__('dashboard.mission.hours_req')}}</th>
									  <th>{{__('dashboard.mission.started_at')}}</th>
									  <th>{{__('dashboard.action')}}</th>
								  </tr>
							  </thead>
							  <tbody>
								@foreach($missionInProgress as $key => $result)
								  <tr>
									  <td>{{$key+1}}.</td>
									  <td>{{$result->title}}</td>
									  <td>{{$result->location}}</td>
									  <td>{{($result->total_hours) ? date('H:i', strtotime($result->total_hours)):'N/A'}}</td>
									  <td>{{($result->start_date_time) ? $result->start_date_time:'N/A'}}</td>
									  <td><p><a href="{{url('customer/mission-requests/view')}}/{{Helper::encrypt($result->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
								  </tr>
								@endforeach
							  </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- Misison finished tab -->
                   <div class="tab-pane fade show @if($page_name=='finished') active @endif" id="nav-mission-finished" role="tabpanel" aria-labelledby="nav-finished-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
								  <tr>
									  <th>#</th>
									  <th>{{__('dashboard.mission.title')}}</th>
									  <th>{{__('dashboard.mission.location')}}</th>
									  <th>{{__('dashboard.mission.hours_req')}}</th>
									  <th>{{__('dashboard.mission.started_at')}}</th>
									  <th>{{__('dashboard.action')}}</th>
								  </tr>
							  </thead>
							  <tbody>
								@foreach($missionCompleted as $key => $result)
								  <tr>
									  <td>{{$key+1}}.</td>
									  <td>{{$result->title}}</td>
									  <td>{{$result->location}}</td>
									  <td>{{($result->total_hours) ? date('H:i', strtotime($result->total_hours)):'N/A'}}</td>
									  <td>{{($result->start_date_time) ? $result->start_date_time:'N/A'}}</td>
									  <td><p><a href="{{url('customer/mission-requests/view')}}/{{Helper::encrypt($result->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
								  </tr>
								@endforeach
							  </tbody>
                        </table>
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
@endsection