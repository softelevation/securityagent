@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-6">
                    <h2>Missions</h2>
                </div>
                <div class="col-md-6 text-right m-0 d-inline">
                    <a href="#" class="btn_submit"><i class="fa fa-edit"></i> Create New Mission</a>
                </div>
              </div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-25">
                          <a id="nav-all-mission-tab" data-toggle="tab" href="#nav-mission-all" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='all') active @endif">All Missions </a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-in-progress-tab" data-toggle="tab" href="#nav-mission-in-progress" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='inprogress') active @endif">Missions In Progress</a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-mission-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='pending') active @endif">Missions Pending</a>
                      </li>
                      <li class="nav-item w-25">
                          <a id="nav-finished-tab" data-toggle="tab" href="#nav-mission-finished" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='finished') active @endif">Missions Finished</a>
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
                                    <th>Mission Title</th>
                                    <th>Mission Location</th>
                                    <th>Mission Status</th>
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
                                    <td>{{$mission->location}}</td>
                                    <td>{{$status_list[$mission->status]}}</td>
                                    <td>
                                      @if($mission->status==0)
                                        @php $url = url('customer/quick_mission/edit/'.Helper::encrypt($mission->id)); @endphp
                                        @if($mission->step==2)
                                          @php $url = url('customer/find-mission-agent/'.Helper::encrypt($mission->id)); @endphp
                                        @endif
                                        <a class="action_icons" href="{{$url}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> Edit </a>
                                      @endif
                                      <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">No record found</td>
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
                    <div class="tab-pane fade show @if($page_name=='inprogress') active @endif" id="nav-mission-in-progress" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mission Title</th>
                                    <th>Mission Location</th>
                                    <th>Mission Duration</th>
                                    <th>Mission Start At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='inprogress'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($inprogress_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} Hour(s)</td>
                                    <td>{{date('m/d/Y H:i:s', strtotime($mission->started_at))}}</td>
                                    <td>
                                      <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">No record found</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$inprogress_mission->links()}}
                          </nav>
                        </div>
                      </div>
                    </div>
                    <!-- Missions pending tab -->
                    <div class="tab-pane fade show @if($page_name=='pending') active @endif" id="nav-mission-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mission Title</th>
                                    <th>Mission Location</th>
                                    <th>Mission Duration</th>
                                    <th>Mission Start Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0;
                                if($page_name=='pending'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                } 
                              @endphp
                              @forelse($pending_mission as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} Hour(s)</td>
                                    <td>@if($mission->quick_book==1) Now (Quick Booking) @else {{$mission->start_date}} @endif</td>
                                    <td>
                                      <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">No record found</td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$pending_mission->links()}}
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
                                    <th>Mission Title</th>
                                    <th>Mission Location</th>
                                    <th>Mission Started At</th>
                                    <th>Mission Ended At</th>
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
                                    <td>{{$mission->location}}</td>
                                    <td>{{date('m/d/Y H:i:s', strtotime($mission->started_at))}}</td>
                                    <td>{{date('m/d/Y H:i:s', strtotime($mission->ended_at))}}</td>
                                    <td>
                                      <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="6">No record found</td>
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