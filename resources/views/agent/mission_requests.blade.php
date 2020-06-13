@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
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
                      <li class="nav-item w-50">
                          <a id="nav-awaiting-tab" data-toggle="tab" href="#nav-awaiting" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='awaiting') active @endif">{{__('dashboard.agents.awaiting_requests')}}</a>
                      </li>
                      <li class="nav-item w-50">
                          <a id="nav-expired-tab" data-toggle="tab" href="#nav-expired" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='expired') active @endif">{{__('dashboard.agents.expired_requests')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- Pending Agents -->
                    <div class="tab-pane fade show @if($page_name=='awaiting') active @endif" id="nav-awaiting" role="tabpanel" aria-labelledby="nav-awaiting-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.mission.start_time')}}</th>
                                    <th>{{__('dashboard.agents.request_timeout')}}</th>
                                    <th>{{__('dashboard.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='awaiting'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($awaiting_requests as $mission)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$mission->title}}</td>
                                    <td>{{$mission->location}}</td>
                                    <td>{{$mission->total_hours}} {!!__('dashboard.hours')!!}</td>
                                    <td>@if($mission->quick_book==1) {{__('dashboard.now')}} ({{__('dashboard.quick_booking')}}) @else {{Helper::date_format_show('d/m/Y H:i:s',$mission->start_date_time)}} @endif</td>
                                    @php $timerDivId = 'req'.$mission->id; @endphp
                                    <td><p class="timeout_p" id="req{{$mission->id}}" data-record-id="{{Helper::encrypt($mission->id)}}" data-timeout="{{Helper::get_timeout_datetime($mission->assigned_at)}}"></p></td>
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
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$awaiting_requests->links()}}
                          </nav>
                        </div>
                      </div>
                    </div>
                    <!-- Verified Agents -->
                    <div class="tab-pane fade show @if($page_name=='expired') active @endif" id="nav-expired" role="tabpanel" aria-labelledby="nav-expired-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.mission.title')}}</th>
                                    <th>{{__('dashboard.mission.location')}}</th>
                                    <th>{{__('dashboard.mission.duration')}}</th>
                                    <th>{{__('dashboard.status')}}</th>
                                    <th>{{__('dashboard.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php 
                                $i = 0; 
                                if($page_name=='expired'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($expired_requests as $data)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{$data->mission_details->title}}</td>
                                    <td>{{$data->mission_details->location}}</td>
                                    <td>{{$data->mission_details->total_hours}} {!!__('dashboard.hours')!!}</td>
                                    <td><button class="btn btn-outline-danger status_btn">{{__('dashboard.expired')}}</button></td>
                                    <td>
                                      <a href="{{url('agent/mission-details/view')}}/{{Helper::encrypt($data->mission_details->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                      <a href="{{url('agent/remove-expired-mission/')}}/{{Helper::encrypt($data->id)}}" class="action_icons remove_mission_request"><i class="fas fa-trash text-grey" aria-hidden="true"></i> {{__('dashboard.delete')}} </a>
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
                      <div class="row">
                        <div class="ml-auto mr-auto">
                          <nav class="navigation2 text-center" aria-label="Page navigation">
                            {{$expired_requests->links()}}
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
{{Form::open(['url'=>url('agent/mission-expired'),'id'=>'general_form'])}}
{{Form::hidden('record_id',null,['id'=>'expired_mission_id'])}}
{{Form::close()}}
@endsection