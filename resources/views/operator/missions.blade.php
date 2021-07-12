@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
                <!--<div class="float-left">-->
                <div class="col-md-12 ">
                    <div class="col-md-2 float-left">
                        <h2>{{__('dashboard.missions')}}</h2>
                    </div>
					<form>
                    <div class="col-md-3  float-left form-group">
                        @if(!app('request')->input('archived'))
                            <select class="form-control" name="missionStatus" id="filterMissionStatus"> 
                                <option value="" disabled selected>{{__('dashboard.search_by_mission_status')}}</option>
                                <option value="all">{{__('dashboard.mission.all')}}</option>
                                @foreach(Helper::get_mission_status_array() as $idx => $val)
                                <option value='{{$idx}}' @if((null != app('request')->input('missionStatus')) &&  app('request')->input('missionStatus') >=0 &&  app('request')->input('missionStatus') >=0!== 'all' && app('request')->input('missionStatus')==$idx) selected="selected" @endif>{{$val}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
					<div class="col-md-3  float-left form-group">
                            <input type="text" name="search" value="{{app('request')->input('search')}}" class="form-control" placeholder="{{__('dashboard.customer_name')}}"></input>
                    </div>
					<div class="col-md-2  float-left form-group">
                            <input type="submit" class="form-control" id="filterMissionStatus" value="{{__('dashboard.search')}}"></input>
                    </div>
					</form>
                    <div class="col-md-2 float-right pt-3">
                        <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="tab-pane">
                    <div class="border" id="myTabContent">
                        <ul class="nav nav-tabs">
                            @if(app('request')->input('archived'))
                                <li class="nav-item w-25">
                                    <a id="nav-archived-mission-tab" data-toggle="tab" href="#nav-mission-archived" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='archived') active @endif">{{__('dashboard.mission.archive_mission')}} </a>
                                </li>
                            @else
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
                            @endif
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
                                                <!-- <th>{{__('dashboard.mission.location')}}</th> -->
                                                <th>{{__('dashboard.mission.status')}}</th>
                                                <th>{{__('dashboard.customer_name')}}</th>
                                                <th>{{__('dashboard.payment.status')}}</th>
                                                <th>{{__('dashboard.created_at')}}</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $i = 0;
                                            @endphp
                                            @foreach($mission_all as $mission)
                                            @php $i++; @endphp
                                            <tr>
                                                <td>{{$i}}.</td>
                                                <td>{{$mission->title}}</td>
                                                <td>{{Helper::mission_id_str($mission->id)}}</td>
                                                <!-- <td>{{$mission->location}}</td> -->
                                                <td>{{Helper::get_mission_status($mission->status)}}</td>
                                                <td>{{ucfirst($mission->first_name.' '.$mission->last_name)}}</td>
												<td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @elseif($mission->payment_status==2) {{__('dashboard.payment.bank_transfer')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                                <td>{{Helper::date_format_show('d/m/Y H:i:s',$mission->created_at)}}</td>
                                                <td>
													@if($mission->quick_book==1 && $mission->agent_id==0)
                                                    @if(Helper::check_mission_assigning_delay($mission->created_at)==true)
                                                    <span class="text-info" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="{{__('dashboard.mission.assign_delay_text')}}"><i class="fa fa-exclamation-circle"></i></span>
                                                    @endif
                                                    @endif
                                                    @if($mission->quick_book==1 && $mission->status==3 && $mission->assigned_at!=null)
                                                    @if(Helper::check_mission_starting_delay($mission->assigned_at)==true)
                                                    <span class="text-danger" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="{{__('dashboard.mission.start_delay_text')}}"><i class="fa fa-exclamation-circle"></i></span>
                                                    @endif
                                                    @endif
													
													@if($mission->status != 5)
													<p><a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p>
													@else
													<div class="dropdown">
                                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
															@if($mission->status == 5)
                                                            <a href="{{url('operator/mission_chage_status/archive')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-trash text-grey" aria-hidden="true"></i> {{__('dashboard.mission.archive')}}</a>
															@endif
															@if($mission->status==5 && $mission->reports_id != null)
															<a href="{{url('operator/report-view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-rss-square" aria-hidden="true"></i> {{__('frontend.text_155')}}</a>
															@endif
														</div>
                                                    </div>
													@endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
								<div class="row">
                                    <div class="ml-auto mr-auto">
                                        <nav class="navigation2 text-center" aria-label="Page navigation">
                                            <ul class="pagination" role="navigation">
													<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
														<span class="page-link" aria-hidden="true">‹</span>
													</li>
													<?php for($i=1; $i<=$mission_all_count; $i++){ ?>
                                                    <li class="page-item @if($page_no == $i && $page_name == 'all') active @endif"><a class="page-link" href="{{ url('operator/missions?all='.$i) }}">{{$i}}</a></li>
													<?php } ?>
													<li class="page-item">
														<a class="page-link" href="{{url('operator/missions?all='.$i)}}" rel="next" aria-label="Next »">›</a>
													</li>
											</ul>
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
												<th>{{__('dashboard.customer_name')}}</th>
                                                <th>{{__('dashboard.mission.status')}}</th>
                                                <th>{{__('dashboard.created_at')}}</th>
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
                                            @foreach($future_mission as $mission)
                                            @php $i++; @endphp
                                            <tr>
                                                <td>{{$i}}.</td>
                                                <td>{{$mission->title}}</td>
                                                <td>{{Helper::mission_id_str($mission->id)}}</td>
                                                <td>{{$mission->total_hours}} Hour(s)</td>
                                                <td>{{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}}</td>
												<td>{{ucfirst($mission->first_name.' '.$mission->last_name)}}</td>
                                                <td>{{Helper::get_mission_status($mission->status)}}</td>
                                                <td>{{Helper::date_format_show('d/m/Y H:i:s',$mission->created_at)}}</td>
                                                <td>
													@if($mission)
                                                    @if($mission->agent_id!=0)
                                                    <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a><br/>
                                                    @if($mission->status == 5)
                                                    <a href="{{url('operator/mission_chage_status/archive')}}/{{Helper::encrypt($mission->id)}}" class="action_icons archiveMission"><i class="fas fa-trash text-grey" aria-hidden="true"></i> {{__('dashboard.mission.archive')}}</a>
                                                    @endif
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
                                                    <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a><br/>
                                                    @if($mission->status == 5)
                                                    <a href="{{url('operator/mission_chage_status/archive')}}/{{Helper::encrypt($mission->id)}}" class="action_icons archiveMission"><i class="fas fa-trash text-grey" aria-hidden="true"></i> {{__('dashboard.mission.archive')}}</a>
                                                    @endif
                                                    @endif 
												
												</td>
                                                
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
                                                <th>{{__('dashboard.mission.title')}}</th>
                                                <th>{{__('dashboard.mission.ref')}}</th>
                                                <!-- <th>{{__('dashboard.mission.location')}}</th> -->
                                                <th>{{__('dashboard.mission.duration')}}</th>
												<th>{{__('dashboard.customer_name')}}</th>
                                                <th>{{__('dashboard.mission.status')}}</th>
                                                <th>{{__('dashboard.created_at')}}</th>
                                                <th></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											@php 
                                            $i = 0; 
                                            @endphp
											@foreach($quick_mission as $mission)
                                            @php $i++; @endphp
											
                                            <tr>
                                                <td>{{$i}}.</td>
                                                <td>{{$mission->title}}</td>
                                                <td>{{Helper::mission_id_str($mission->id)}}</td>
                                                <!-- <td>{{$mission->location}}</td> -->
                                                <td>{{$mission->total_hours}} Hour(s)</td>
												<td>{{ucfirst($mission->first_name.' '.$mission->last_name)}}</td>
                                                <td>{{Helper::get_mission_status($mission->status)}}</td>
                                                <td>{{Helper::date_format_show('d/m/Y H:i:s',$mission->created_at)}}</td>
                                                <td>
                                                    @if($mission->quick_book==1 && $mission->agent_id==0)
                                                    @if(Helper::check_mission_assigning_delay($mission->created_at)==true)
                                                    <span class="text-info" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="{{__('dashboard.mission.assign_delay_text')}}"><i class="fa fa-exclamation-circle"></i></span>
                                                    @endif
                                                    @endif
                                                    @if($mission->quick_book==1 && $mission->status==3 && $mission->assigned_at!=null)
                                                    @if(Helper::check_mission_starting_delay($mission->assigned_at)==true)
                                                    <span class="text-danger" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="{{__('dashboard.mission.start_delay_text')}}"><i class="fa fa-exclamation-circle"></i></span>
                                                    @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a><br/>
														@if($mission->status == 5)
														<a href="{{url('operator/mission_chage_status/archive')}}/{{Helper::encrypt($mission->id)}}" class="action_icons archiveMission"><i class="fas fa-trash text-grey" aria-hidden="true"></i> {{__('dashboard.mission.archive')}}</a>
														@endif
                                                </td>
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
                                                <th>{{__('dashboard.mission.ref')}}</th>
                                                <th>{{__('dashboard.mission.location')}}</th>
												<th>{{__('dashboard.customer_name')}}</th>
                                                <th>{{__('dashboard.mission.started_at')}}</th>
                                                <th>{{__('dashboard.mission.ended_at')}}</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $i = 0; 
                                            @endphp
											@foreach($finished_mission as $mission)
                                            @php $i++; @endphp
                                            <tr>
                                                <td>{{$i}}.</td>
                                                <td>{{$mission->title}}</td>
                                                <td>{{Helper::mission_id_str($mission->id)}}</td>
                                                <td>{{$mission->location}}</td>
												<td>{{ucfirst($mission->first_name.' '.$mission->last_name)}}</td>
                                                <td>@if(isset($mission->started_at)){{date('d/m/Y H:i:s', strtotime($mission->started_at))}}@endif</td>
                                                <td>@if(isset($mission->started_at)){{date('d/m/Y H:i:s', strtotime($mission->ended_at))}}@endif</td>
                                                <td>
												<div class="dropdown">
													<a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a>
														@if($mission->status==5 && $mission->reports_id != null)
														<a href="{{url('operator/report-view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-rss-square" aria-hidden="true"></i> {{__('frontend.text_155')}}</a>
														@endif
													</div>
												</div>
												</td>
                                            </tr>
                                            @endforeach  
                                        </tbody>
                                    </table>
                                </div>
								<div class="row">
                                    <div class="ml-auto mr-auto">
                                        <nav class="navigation2 text-center" aria-label="Page navigation">
                                            <ul class="pagination" role="navigation">
													<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
														<span class="page-link" aria-hidden="true">‹</span>
													</li>
													<?php for($i=1; $i<=$missionCompleted_count; $i++){ ?>
                                                    <li class="page-item @if($page_no == $i && $page_name == 'finished') active @endif"><a class="page-link" href="{{ url('operator/missions?finished='.$i) }}">{{$i}}</a></li>
													<?php } ?>
													<li class="page-item">
														<a class="page-link" href="{{url('operator/missions?all='.$i)}}" rel="next" aria-label="Next »">›</a>
													</li>
											</ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Archived Missions -->

                            <div class="tab-pane fade show @if($page_name=='archived') active @endif" id="nav-mission-archived" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('dashboard.mission.title')}}</th>
                                                <th>{{__('dashboard.mission.ref')}}</th>
                                                <!-- <th>{{__('dashboard.mission.location')}}</th> -->
                                                <th>{{__('dashboard.mission.status')}}</th>
												<th>{{__('dashboard.customer_name')}}</th>
                                                <th>{{__('dashboard.payment.status')}}</th>
                                                <th>{{__('dashboard.created_at')}}</th>
                                                <th>{{__('dashboard.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $i = 0;
                                            @endphp
                                            @foreach($archived_mission as $mission)
                                            @php $i++; @endphp
                                            <tr>
                                                <td>{{$i}}.</td>
                                                <td>{{$mission->title}}</td>
                                                <td>{{Helper::mission_id_str($mission->id)}}</td>
                                                <td>{{Helper::get_mission_status($mission->status)}}</td>
                                                <td>{{ucfirst($mission->first_name.' '.$mission->last_name)}}</td>
												<td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @elseif($mission->payment_status==2) {{__('dashboard.mission.bank_transfer')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                                <td>{{Helper::date_format_show('d/m/Y H:i:s',$mission->created_at)}}</td>
                                                <td>
													<div class="dropdown">
                                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>

                                                            <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-plus-square text-grey" aria-hidden="true"></i> {{__('dashboard.agents.assign')}}</a>
															@if($mission->total_hours > 12)
                                                            <a class="dropdown-item" href="{{url('operator/sub-mission')}}/{{Helper::encrypt($mission->id)}}"><i class="fas fa-border-all text-grey" aria-hidden="true"></i> {{__('dashboard.mission.create_sub')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                   
                                                </td>
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