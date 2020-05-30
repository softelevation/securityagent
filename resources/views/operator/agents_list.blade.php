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
                  <h2>{{__('dashboard.agents.agents')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-50">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='pending') active @endif">{{__('dashboard.agents.pending_heading')}} </a>
                      </li>
                      <li class="nav-item w-50">
                          <a id="nav-verified-tab" data-toggle="tab" href="#nav-verified" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='verified') active @endif">{{__('dashboard.agents.verified_heading')}}</a>
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
                                    <th>{{__('dashboard.agents.name')}}</th>
                                    <th>{{__('dashboard.agents.username')}}</th>
                                    <th>{{__('dashboard.agents.type')}}</th>
                                    <th>{{__('dashboard.email')}}</th>
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
                              @forelse($pending_agents as $agent)
                                @php $i++; @endphp
                                @php $en_id = Helper::encrypt($agent->id); @endphp
                                <tr> 
                                    <td>{{$i}}.</td>
                                    <td>{{ucfirst($agent->first_name)}} {{ucfirst($agent->last_name)}}</td>
                                    <td>{{ucfirst($agent->username)}}</td>
                                    <td>{{Helper::get_agent_type_name_multiple($agent->types)}}</td>
                                    <td>{{$agent->user->email}}</td>
                                    <td>
                                      <a class="action_icons" href="{{url('operator/agent/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a></br>
                                     
                                      @if(Auth::user()->role_id == 3)
                                        <a class="action_icons" onclick="return confirm('Are you sure you want to delete?');" href="{{url('operator/agent/delete/'.$en_id)}}"> <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>
                                      @endif

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
                            {{$pending_agents->links()}}
                          </nav>
                        </div>
                      </div>
                    </div>
                    <!-- Verified Agents -->
                    <div class="tab-pane fade show @if($page_name=='verified') active @endif" id="nav-verified" role="tabpanel" aria-labelledby="nav-verified-tab">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.agents.name')}}</th>
                                    <th>{{__('dashboard.agents.username')}}</th>
                                    <th>{{__('dashboard.agents.type')}}</th>
                                    <!-- <th>{{__('dashboard.email')}}</th> -->
                                    <th>{{__('dashboard.status')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php  
                                $i = 0; 
                                if($page_name=='verified'){
                                  $records = $limit*($page_no-1);
                                  $i = $i+$records;
                                }
                              @endphp
                              @forelse($verified_agents as $agent)
                                @php $i++; @endphp
                                @php $en_id = Helper::encrypt($agent->id); @endphp
                                <tr>
                                    <td>{{$i}}.</td>
                                    <td>{{ucfirst($agent->first_name)}} {{ucfirst($agent->last_name)}}</td>
                                    <td>{{ucfirst($agent->username)}}</td>
                                    <td>{{Helper::get_agent_type_name_multiple($agent->types)}}</td>
                                    <!-- <td>{{$agent->user->email}}</td> -->
                                    <td>
                                      @if($agent->status==1)
                                      <span class="btn btn-outline-success status_outline"> Active </span> @else 
                                        <span class="btn btn-outline-danger status_outline"> Blocked </span>
                                      @endif</td>
                                    <td>
                                      <a class="action_icons" href="{{url('operator/agent/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a>
                                      @if($agent->status==3)
                                        <a id="{{Helper::encrypt($agent->id)}}" data-type="0" class="action_icons block_un_agent" href="javascript:void(0)"><i class="fas fa-toggle-off text-grey" aria-hidden="true"></i> {{__('dashboard.unblock')}}</a>
                                      @else
                                        <a id="{{Helper::encrypt($agent->id)}}" data-type="1" class="action_icons block_un_agent" href="javascript:void(0)"><i class="fas fa-toggle-on text-grey" aria-hidden="true"></i> {{__('dashboard.block')}}</a>
                                      @endif
 
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
                            {{$verified_agents->links()}}
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
{{Form::open(['url'=>url('operator/block-unblock-agent'),'id'=>'general_form'])}}
{{Form::hidden('agent_id',null,['id'=>'agent_id'])}}
{{Form::hidden('type',null,['id'=>'type'])}}
{{Form::close()}}
@endsection
