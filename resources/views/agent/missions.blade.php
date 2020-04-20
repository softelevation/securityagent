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
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-33">
                          <a id="nav-in-progress-tab" data-toggle="tab" href="#nav-mission-in-progress" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">{{__('dashboard.mission.in_progress')}}</a>
                      </li>
                      <li class="nav-item w-33">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-mission-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link ">{{__('dashboard.mission.pending')}}</a>
                      </li>
                      <li class="nav-item w-33">
                          <a id="nav-finished-tab" data-toggle="tab" href="#nav-mission-finished" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link">{{__('dashboard.mission.finished')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- Missions in progress tab -->
                    <div class="tab-pane fade show active" id="nav-mission-in-progress" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.mission.started_at')}}</th>
                                    <th>{{__('dashboard.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php $i = 0; @endphp
                              @forelse($inprogress_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} {{__('dashboard.hours')}}</td>
                                    <td>{{Helper::date_format_show('d/m/Y H:i:s',$mission->started_at)}}</td>
                                    <td>
                                      <a href="{{url('agent/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="7">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- Missions pending tab -->
                    <div class="tab-pane fade" id="nav-mission-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.mission.start_time')}}</th>
                                    <th>{{__('dashboard.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php $i = 0; @endphp
                              @forelse($pending_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} {{__('dashboard.hours')}}</td>
                                    <td>@if($mission->quick_book==1) {{__('dashboard.now')}} ({{__('dashboard.quick_booking')}}) @else {{Helper::date_format_show('d/m/Y H:i:s',$mission->start_date_time)}} @endif</td>
                                    <td>
                                      <a href="{{url('agent/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- Misison finished tab -->
                    <div class="tab-pane fade" id="nav-mission-finished" role="tabpanel" aria-labelledby="nav-finished-tab">
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
                                    <th>{{__('dashboard.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php $i = 0; @endphp
                              @forelse($finished_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($mission->started_at))}}</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($mission->ended_at))}}</td>
                                    <td>
                                      <a href="{{url('agent/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                        <!-- <div class="dropdown ac-cstm">
                                            <a class="dropdown-toggle" data-toggle="dropdown">
                                                <img src="{{asset('assets/images/dots.png')}}">
                                            </a>
                                            <div class="dropdown-menu fadeIn">
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target=""><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Block/Unblock</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                            </div>
                                        </div> -->
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">{{__('dashboard.no_record')}}</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="ml-auto mr-auto">
                          <!-- <nav class="navigation2 text-center" aria-label="Page navigation">
                              <ul class="pagination mb-3">
                                  <li class="page-item"><a class="page-link" href="#"><span aria-hidden="true">←</span>Prev</a></li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item"><a class="page-link" href="#">Next <span aria-hidden="true">→</span></a></li>
                              </ul>
                          </nav> -->
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