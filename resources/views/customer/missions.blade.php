@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
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
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.mission_status')}}</th>
                                    <th>{{__('dashboard.mission.payment_status')}}</th>
                                    <th>{{__('dashboard.action')}}</th>
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
                                    <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @elseif($mission->payment_status==2) {{__('dashboard.mission.bank_transfer')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                    <td>
                                      <div class="dropdown">
                                          <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($mission->status==0 && $mission->payment_status==0)
                                              <a class="dropdown-item" href="{{url('customer/quick_mission/edit/'.Helper::encrypt($mission->id))}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> {{__('dashboard.mission.edit')}}</a>
                                            @endif
                                            <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                            @if($mission->payment_status==1 && ($mission->status!=5 && $mission->status!=6 && $mission->status!=7) && ($mission->child_missions->count()==0))
                                              <a href="{{url('customer/cancel-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item cancel_mission_cls"><i class="fas fa-window-close text-grey" aria-hidden="true"></i> {{__('dashboard.mission.cancel')}}</a>
                                            @endif
                                            @if($mission->status==0 && $mission->payment_status==0)
                                              <a href="{{url('customer/delete-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item delete_mission_cls"><i class="fas fa-trash-alt text-grey" aria-hidden="true"></i> {{__('dashboard.mission.delete')}}</a>
                                            @endif
                                          </div>
                                      </div>
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                  <tr>
                                      <td></td>
                                      <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                      <td>{{Helper::mission_id_str($mission->id)}}</td>
                                      <td>{{$mission->location}}</td>
                                      <td>@if($mission->child_missions->count() > 0) {{__('dashboard.mission.parent')}} @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                      <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @elseif($mission->payment_status==2) {{__('dashboard.mission.bank_transfer')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                      <td>
                                        <div class="dropdown">
                                          <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($mission->status==0 && $mission->payment_status==0)
                                              <a class="dropdown-item" href="{{url('customer/quick_mission/edit/'.Helper::encrypt($mission->id))}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> {{__('dashboard.mission.edit')}}</a>
                                            @endif
                                            <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                            @if($mission->payment_status==1 && ($mission->status!=5 && $mission->status!=6 && $mission->status!=7))
                                              <a href="{{url('customer/cancel-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item cancel_mission_cls"><i class="fas fa-window-close text-grey" aria-hidden="true"></i> {{__('dashboard.mission.cancel')}}</a>
                                            @endif
                                            @if($mission->status==0 && $mission->payment_status==0)
                                              <a href="{{url('customer/delete-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item delete_mission_cls"><i class="fas fa-trash-alt text-grey" aria-hidden="true"></i> {{__('dashboard.mission.delete')}}</a>
                                            @endif
                                          </div>
                                        </div>
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
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
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
                                    <td>{{$mission->title}} @if($mission->parent_id!=0)<small class="action_icons">({{__('dashboard.mission.sub')}})</small>@endif</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} {{__('dashboard.hours')}}</td>
                                    <td>
                                      <div class="dropdown">
                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          @if($mission->status==0 && $mission->payment_status==0)
                                            <a class="dropdown-item" href="{{url('customer/quick_mission/edit/'.Helper::encrypt($mission->id))}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> {{__('dashboard.mission.edit')}}</a>
                                          @endif
                                          <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                          @if($mission->payment_status==1 && ($mission->status!=5 && $mission->status!=6 && $mission->status!=7))
                                            <a href="{{url('customer/cancel-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item cancel_mission_cls"><i class="fas fa-window-close text-grey" aria-hidden="true"></i> {{__('dashboard.mission.cancel')}}</a>
                                          @endif
                                          @if($mission->status==0 && $mission->payment_status==0)
                                            <a href="{{url('customer/delete-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item delete_mission_cls"><i class="fas fa-trash-alt text-grey" aria-hidden="true"></i> {{__('dashboard.mission.delete')}}</a>
                                          @endif
                                        </div>
                                      </div>
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
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.ref')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.start_time')}}</th>
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
                                    <td>{{$mission->title}} @if($mission->parent_id!=0)<small class="action_icons">({{__('dashboard.mission.sub')}})</small>@endif</td>
                                    <td>{{Helper::mission_id_str($mission->id)}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>@if($mission->quick_book==1) {{__('dashboard.now')}} ({{__('dashboard.quick_booking')}}) @else {{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}} @endif</td>
                                    <td>
                                      <div class="dropdown">
                                        <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          @if($mission->status==0 && $mission->payment_status==0)
                                            <a class="dropdown-item" href="{{url('customer/quick_mission/edit/'.Helper::encrypt($mission->id))}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> {{__('dashboard.mission.edit')}}</a>
                                          @endif
                                          <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                          @if($mission->payment_status==1 && ($mission->status!=5 && $mission->status!=6 && $mission->status!=7))
                                            <a href="{{url('customer/cancel-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item cancel_mission_cls"><i class="fas fa-window-close text-grey" aria-hidden="true"></i> {{__('dashboard.mission.cancel')}}</a>
                                          @endif
                                          @if($mission->status==0 && $mission->payment_status==0)
                                            <a href="{{url('customer/delete-mission')}}/{{Helper::encrypt($mission->id)}}" class="dropdown-item delete_mission_cls"><i class="fas fa-trash-alt text-grey" aria-hidden="true"></i> {{__('dashboard.mission.delete')}}</a>
                                          @endif
                                        </div>
                                      </div>
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
                                    <th>{{__('dashboard.mission.title')}}</th>
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
                                    <td>{{$mission->location}}</td>
                                    <td>@if(isset($mission->started_at)){{date('d/m/Y H:i:s', strtotime($mission->started_at))}}@endif</td>
                                    <td>@if(isset($mission->started_at)){{date('d/m/Y H:i:s', strtotime($mission->ended_at))}}@endif</td>
                                    <td>
                                      <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
                                    </td>
                                </tr>
                                @forelse($mission->child_missions as $mission)
                                  <tr>
                                      <td></td>
                                      <td>{{$mission->title}} <small class="action_icons">({{__('dashboard.mission.sub')}})</small></td>
                                      <td>{{$mission->location}}</td>
                                      <td>@if($mission->child_missions->count() > 0) {{__('dashboard.mission.parent')}} @else {{Helper::get_mission_status($mission->status)}} @endif</td>
                                      <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                      <td>
                                        <a href="{{url('customer/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.mission.view_details')}}</a>
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