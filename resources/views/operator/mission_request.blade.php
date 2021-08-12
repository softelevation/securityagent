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
                                    <a id="nav-all-mission-tab" data-toggle="tab" href="#nav-mission-all" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='all') active @endif">{{__('dashboard.mission.all')}} </a>
                                </li>
                                <li class="nav-item w-25">
                                    <a id="nav-future-tab" data-toggle="tab" href="#nav-mission-future" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='future') active @endif">{{__('dashboard.mission.future')}}</a>
                                </li>
                                <li class="nav-item w-25">
                                    <a id="nav-quick-tab" data-toggle="tab" href="#nav-mission-quick" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='quick') active @endif">{{__('dashboard.mission.quick')}}</a>
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
												  <th>{{__('dashboard.customer_name')}}</th>
												  <th>{{__('dashboard.mission.title')}}</th>
												  <th>{{__('dashboard.mission.mission_hours')}}</th>
												  <th>{{__('dashboard.mission.location')}}</th>
												  <th>Action</th>
											  </tr>
										  </thead>
										  <tbody>
											@foreach($missionAll as $key => $mission)
											  <tr>
												  <td>{{$key+1}}.</td>
												  <td>{{$mission->first_name}} {{$mission->last_name}}</td>
												  <td>{{$mission->title}}</td>
												  <td>{{($mission->total_hours) ? date('H:i', strtotime($mission->total_hours)):'N/A'}}</td>
												  <td>{{$mission->location}}</td>
												  <td><p><a href="{{url('operator/mission-requests/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
											  </tr>
											@endforeach
										  </tbody>
									  </table>
                                </div>
                            </div>
                            <!-- Missions in progress tab -->
                            <div class="tab-pane fade show @if($page_name=='future') active @endif" id="nav-mission-future" role="tabpanel" aria-labelledby="nav-future-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										  <thead>
											  <tr>
												  <th>#</th>
												  <th>{{__('dashboard.customer_name')}}</th>
												  <th>{{__('dashboard.mission.title')}}</th>
												  <th>{{__('dashboard.mission.mission_hours')}}</th>
												  <th>{{__('dashboard.mission.location')}}</th>
												  <th>Action</th>
											  </tr>
										  </thead>
										  <tbody>
											@foreach($future_mission as $key => $mission)
											  <tr>
												  <td>{{$key+1}}.</td>
												  <td>{{$mission->first_name}} {{$mission->last_name}}</td>
												  <td>{{$mission->title}}</td>
												  <td>{{($mission->total_hours) ? date('H:i', strtotime($mission->total_hours)):'N/A'}}</td>
												  <td>{{$mission->location}}</td>
												  <td><p><a href="{{url('operator/mission-requests/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
											  </tr>
											@endforeach
										  </tbody>
									  </table>
                                </div>
                            </div>
                            <!-- Missions pending tab -->
                            <div class="tab-pane fade show @if($page_name=='quick') active @endif" id="nav-mission-quick" role="tabpanel" aria-labelledby="nav-quick-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
										  <thead>
											  <tr>
												  <th>#</th>
												  <th>{{__('dashboard.customer_name')}}</th>
												  <th>{{__('dashboard.mission.title')}}</th>
												  <th>{{__('dashboard.mission.mission_hours')}}</th>
												  <th>{{__('dashboard.mission.location')}}</th>
												  <th>Action</th>
											  </tr>
										  </thead>
										  <tbody>
											@foreach($quick_mission as $key => $mission)
											  <tr>
												  <td>{{$key+1}}.</td>
												  <td>{{$mission->first_name}} {{$mission->last_name}}</td>
												  <td>{{$mission->title}}</td>
												  <td>{{($mission->total_hours) ? date('H:i', strtotime($mission->total_hours)):'N/A'}}</td>
												  <td>{{$mission->location}}</td>
												  <td><p><a href="{{url('operator/mission-requests/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
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
												  <th>{{__('dashboard.customer_name')}}</th>
												  <th>{{__('dashboard.mission.title')}}</th>
												  <th>{{__('dashboard.mission.mission_hours')}}</th>
												  <th>{{__('dashboard.mission.location')}}</th>
												  <th>Action</th>
											  </tr>
										  </thead>
										  <tbody>
											@foreach($finished_mission as $key => $mission)
											  <tr>
												  <td>{{$key+1}}.</td>
												  <td>{{$mission->first_name}} {{$mission->last_name}}</td>
												  <td>{{$mission->title}}</td>
												  <td>{{($mission->total_hours) ? date('H:i', strtotime($mission->total_hours)):'N/A'}}</td>
												  <td>{{$mission->location}}</td>
												  <td><p><a href="{{url('operator/mission-requests/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
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