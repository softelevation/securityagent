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
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.status')}}</th>
                                    <th>{{__('dashboard.payment.status')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='all'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($mission_all as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>@if($mission->child_missions->count() > 0) {{__('dashboard.mission.parent')}} @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                    <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                    <td>
                                      <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                  <tr>
                                      <td></td>
                                      <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                      <td>{{Helper::mission_id_str($mission->id)}}</td>
                                      <td>{{$mission->location}}</td>
                                      <td>@if($mission->child_missions->count() > 0) Parent Mission @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                      <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                      <td>
                                        @if($mission->agent_id!=0)
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                        @else
                                        <div class="dropdown">
                                          <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>

                                            <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>
                                          </div>
                                        </div>
                                        @endif
                                      </td>
                                  </tr>
                                  @empty
                                  @endforelse
                              @empty
                                <tr>
                                    <td colspan="7">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$mission_all->links()}}
                          </nav>
                        </div>
                      </div>
                    </div>
                    <!-- Missions in progress tab -->
                    <div class="tab-pane fade show @if($page_name=='future') active @endif" id="nav-mission-future" role="tabpanel" aria-labelledby="nav-future-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.mission.start_time')}}</th>
                                    <th>{{__('dashboard.mission.status')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='future'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($future_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->total_hours}} Hour(s)</td>
                                    <td>{{date('m/d/Y H:i:s', strtotime($mission->start_date_time))}}</td>
                                    <td>@if($mission->child_missions->count() > 0) {{__('dashboard.mission.parent')}} @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                    <td>
                                      @if($mission->child_missions->count() == 0)
                                        @if($mission->agent_id!=0)
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                        @else
                                        <div class="dropdown">
                                          <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>

                                            <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>

                                            <!-- <a class="dropdown-item" href="#"><i class="far fa-plus-square text-grey" aria-hidden="true"></i> Assign Agent</a> -->
                                            @if($mission->total_hours > 12)
                                            <a class="dropdown-item" href="{{url('operator/sub-mission')}}/{{Helper::encrypt($mission->id)}}"><i class="fas fa-border-all text-grey" aria-hidden="true"></i> {{__('dashboard.mission.create_sub')}}</a>
                                            @endif
                                          </div>
                                        </div>
                                        @endif
                                      @else
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                      @endif  
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                <tr>
                                    <td></td>
                                    <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->total_hours}} {{__('dashboard.hours')}}</td>
                                    <td>{{date('m/d/Y H:i:s', strtotime($mission->start_date_time))}}</td>
                                    <td>{{Helper::get_mission_status($mission->status)}}</td>
                                    <td>
                                      @if($mission->agent_id!=0)
                                      <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                      @else
                                      <div class="dropdown">
                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>

                                          <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>
                                        </div>
                                      </div>
                                      @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                              @empty
                                <tr>
                                    <td colspan="7">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$future_mission->links()}}
                          </nav>
                        </div>
                      </div>
                    </div>
                    <!-- Missions pending tab -->
                    <div class="tab-pane fade show @if($page_name=='quick') active @endif" id="nav-mission-quick" role="tabpanel" aria-labelledby="nav-quick-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.mission.status')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='quick'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($quick_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} Hour(s)</td>
                                    <td>@if($mission->child_missions->count() > 0) {{__('dashboard.mission.parent')}} @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                    <td>
                                      @if($mission->child_missions->count() == 0)
                                        @if($mission->agent_id!=0)
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                        @else
                                        <div class="dropdown">
                                          <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>

                                            <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>

                                            <!-- <a class="dropdown-item" href="#"><i class="far fa-plus-square text-grey" aria-hidden="true"></i> Assign Agent</a> -->
                                            <a class="dropdown-item" href="{{url('operator/sub-mission')}}/{{Helper::encrypt($mission->id)}}"><i class="fas fa-border-all text-grey" aria-hidden="true"></i> {{__('dashboard.mission.create_sub')}}</a>
                                          </div>
                                        </div>
                                        @endif
                                      @else
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                      @endif  
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                <tr>
                                    <td></td>
                                    <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} Hour(s)</td>
                                    <td>{{Helper::get_mission_status($mission->status)}}</td>
                                    <td>
                                      @if($mission->agent_id!=0)
                                      <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                      @else
                                      <div class="dropdown">
                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                          <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>
                                        </div>
                                      </div>
                                      @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                              @empty
                                <tr>
                                    <td colspan="6">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$quick_mission->links()}}
                          </nav>
                        </div>
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
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.started_at')}}</th>
                                    <th>{{__('dashboard.mission.ended_at')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='finished'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($finished_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>@if(isset($mission->started_at)){{date('m/d/Y H:i:s', strtotime($mission->started_at))}}@endif</td>
                                    <td>@if(isset($mission->started_at)){{date('m/d/Y H:i:s', strtotime($mission->ended_at))}}@endif</td>
                                    <td>
                                      <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                  <tr>
                                      <td></td>
                                      <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                      <td>{{Helper::mission_id_str($mission->id)}}</td>
                                      <td>{{$mission->location}}</td>
                                      <td>{{date('m/d/Y H:i:s', strtotime($mission->started_at))}}</td>
                                      <td>{{date('m/d/Y H:i:s', strtotime($mission->ended_at))}}</td>
                                      <td>
                                        <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
                                      </td>
                                  </tr>
                                  @empty
                                  @endforelse
                              @empty
                                <tr>
                                    <td colspan="7">No record found</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$finished_mission->links()}}
                          </nav>
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
@endsection