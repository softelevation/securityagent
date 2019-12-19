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
                          <a class="nav-link active">Verification Pending</a>
                      </li>
                      <li class="nav-item w-50">
                          <a class="nav-link">Verified Agents</a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                              <table class="table table-hover table-striped">
                                  <thead>
                                      <tr>
                                          <th>Agent Name</th>
                                          <th>Agent Type</th>
                                          <th>E-mail Address</th>
                                          <th>Work Location</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @forelse($data as $agent)
                                      <tr>
                                          <td>{{$agent->first_name}} {{$agent->last_name}}</td>
                                          <td>{{$agent->agent_type}}</td>
                                          <td>{{$agent->user->email}}</td>
                                          <td>{{$agent->work_location_address}}</td>
                                          <td>
                                              <div class="dropdown ac-cstm">
                                                  <a class="dropdown-toggle" data-toggle="dropdown">
                                                      <img src="{{asset('assets/images/dots.png')}}">
                                                  </a>
                                                  <div class="dropdown-menu fadeIn">
                                                      <a class="dropdown-item" href="" data-toggle="modal" data-target=""><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                                      <a class="dropdown-item" href="#"><i class="fas fa-envelope text-grey" aria-hidden="true"></i> View</a>
                                                      <a class="dropdown-item" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> Block/Unblock</a>
                                                      <a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                                                  </div>
                                              </div>
                                          </td>
                                      </tr>
                                    @empty
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <div class="row">
                              <div class="ml-auto mr-auto">
                                  <nav class="navigation2 text-center" aria-label="Page navigation">
                                      <ul class="pagination mb-3">
                                          <li class="page-item"><a class="page-link" href="#"><span aria-hidden="true">←</span>Prev</a></li>
                                          <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                                          <li class="page-item"><a class="page-link" href="#">Next <span aria-hidden="true">→</span></a></li>
                                      </ul>
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