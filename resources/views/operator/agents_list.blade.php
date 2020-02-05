@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div>
                  <h2>Agents</h2>
              </div>

              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-50">
                          <a id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='pending') active @endif">Pending Verification </a>
                      </li>
                      <li class="nav-item w-50">
                          <a id="nav-verified-tab" data-toggle="tab" href="#nav-verified" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link @if($page_name=='verified') active @endif">Verified Agents</a>
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
                                    <th>Agent Name</th>
                                    <th>Agent Type</th>
                                    <th>Email Address</th>
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
                                    <td>{{$agent->first_name}} {{$agent->last_name}}</td>
                                    <td>{{Helper::get_agent_type_name_multiple($agent->types)}}</td>
                                    <td>{{$agent->user->email}}</td>
                                    <td>
                                      <a class="action_icons" href="{{url('operator/agent/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View details</a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="5">No record found</td>
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
                                    <th>Agent Name</th>
                                    <th>Agent Type</th>
                                    <th>Email Address</th>
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
                                    <td>{{$agent->first_name}} {{$agent->last_name}}</td>
                                    <td>{{Helper::get_agent_type_name_multiple($agent->types)}}</td>
                                    <td>{{$agent->user->email}}</td>
                                    <td>
                                      <a class="action_icons" href="{{url('operator/agent/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View details </a>
                                    </td>
                                </tr>
                              @empty
                                <tr>
                                    <td colspan="5">No record found</td>
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
@endsection