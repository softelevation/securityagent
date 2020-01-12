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
                    <a href="{{url('customer/create-mission')}}" class="btn_submit"><i class="fa fa-edit"></i> Create New Mission</a>
                </div>
              </div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-33">
                          <a class="nav-link active">All Missions</a>
                      </li>
                      <li class="nav-item w-33">
                          <a class="nav-link">Missions In Progress</a>
                      </li>
                      <li class="nav-item w-33">
                          <a class="nav-link">Missions Finished</a>
                      </li>
                  </ul>
                  <div class="table-responsive">
                      <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Mission Title</th>
                                  <th>Agent Needed</th>
                                  <th>Mission Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $i = 0; @endphp
                            @forelse($data as $mission)
                              @php $i++; @endphp
                              <tr>
                                  <td>{{$i}}.</td>
                                  <td>{{$mission->title}}</td>
                                  <td>{{Helper::get_agent_type_name($mission->agent_type)}}</td>
                                  <td>{{$status_list[$mission->status]}}</td>
                                  <td>
                                    <a class="action_icons" href="{{url('customer/quick_mission/edit')}}/{{Helper::encrypt($mission->id)}}"><i class="fas fa-edit text-grey" aria-hidden="true"></i> Edit </a>
                                    <a class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
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
                                  <td colspan="5">No record found</td>
                              </tr>
                            @endforelse
                          </tbody>
                      </table>
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