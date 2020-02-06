@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div>
                  <h2>Mission Requests</h2>
              </div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">List of missions awaiting your response </a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mission Title</th>
                                        <th>Mission Location</th>
                                        <th>Duration</th>
                                        <th>Starts Time</th>
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
                                        <td>{{$mission->title}}</td>
                                        <td>{{$mission->location}}</td>
                                        <td>{{$mission->total_hours}} Hour(s)</td>
                                        <td>@if($mission->quick_book==1) Now (Quick Booking) @else {{$mission->start_date}} @endif</td>
                                        <td>
                                          <a href="{{url('agent/mission-details/view')}}/{{Helper::encrypt($mission->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View </a>
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
                                {{$data->links()}}
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