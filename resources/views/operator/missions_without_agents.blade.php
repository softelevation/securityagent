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
                  <h2>{{__('dashboard.mission.without_agents')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-50">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='pending') active @endif">{{__('dashboard.mission.without_agent_heading')}} </a>
                      </li>
                      <li class="nav-item w-50">
                          <a id="nav-verified-tab" data-toggle="tab" href="#nav-verified" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='verified') active @endif">{{__('dashboard.mission.missionreq_without_agent_heading')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- Pending Agents -->
                    <div class="tab-pane fade show @if($page_name=='pending') active @endif" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('dashboard.mission.title')}}</th>
                                        <th>{{__('dashboard.mission.ref')}}</th>
                                        <th>{{__('dashboard.mission.location')}}</th>
                                        <th>{{__('dashboard.payment.status')}}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php 
                                      $i = 0; 
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                  @forelse($data as $mission)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{$i}}.</td>
                                        <td>{{$mission->title}} @if($mission->parent_id!=0)<small class="action_icons">({{__('dashboard.mission.sub')}})</small>@endif</td>
                                        <td>{{Helper::mission_id_str($mission->id)}}</td>
                                        <td>{{$mission->location}}</td>
                                        <td>@if($mission->payment_status==0) {{__('dashboard.mission.not_paid')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                        <td>
                                          <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>

                                          <a href="{{url('operator/assign-agent')}}/{{Helper::encrypt($mission->id)}}" class="action_icons"><i class="fas fa-user-secret text-grey" aria-hidden="true"></i> {{__('dashboard.assign')}}</a>
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
                    </div>
                    <!-- Verified Agents -->
                    <div class="tab-pane fade show @if($page_name=='verified') active @endif" id="nav-verified" role="tabpanel" aria-labelledby="nav-verified-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('dashboard.mission.title')}}</th>
                                        <th>{{__('dashboard.mission.ref')}}</th>
                                        <th>{{__('dashboard.mission.location')}}</th>
                                        <th>{{__('dashboard.payment.status')}}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php 
                                      $i = 0; 
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                  @forelse($mission_requests as $mission_request)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{$i}}.</td>
                                        <td>{{$mission_request->title}}</td>
                                        <td>{{Helper::mission_id_str($mission_request->id)}}</td>
                                        <td>{{$mission_request->location}}</td>
                                        <td>@if($mission_request->payment_status==0) {{__('dashboard.mission.not_paid')}} @else {{__('dashboard.mission.completed')}} @endif</td>
                                        <td>
                                          <a href="{{url('operator/mission-requests/view')}}/{{Helper::encrypt($mission_request->id)}}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
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
{{Form::open(['url'=>url('operator/block-unblock-agent'),'id'=>'general_form'])}}
{{Form::hidden('agent_id',null,['id'=>'agent_id'])}}
{{Form::hidden('type',null,['id'=>'type'])}}
{{Form::close()}}
@endsection
