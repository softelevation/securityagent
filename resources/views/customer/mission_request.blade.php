@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
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
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.all_mission_requests')}} </a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                              <table class="table table-hover table-striped">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>{{__('dashboard.mission.title')}}</th>
                                          <th>{{__('dashboard.mission.location')}}</th>
                                          <th>{{__('dashboard.mission.hours_req')}}</th>
										  <th>{{__('dashboard.mission.started_at')}}</th>
										  <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($results as $key => $result)
                                      <tr>
                                          <td>{{$key+1}}.</td>
                                          <td>{{$result->title}}</td>
                                          <td>{{$result->location}}</td>
                                          <td>{{($result->total_hours) ? date('H:i', strtotime($result->total_hours)):'N/A'}}</td>
										  <td>{{($result->start_date_time) ? $result->start_date_time:'N/A'}}</td>
                                          <td><p><a href="{{url('customer/mission-requests/view')}}/{{Helper::encrypt($result->id)}}" class="action_icons" href="#"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}} </a></p></td>
                                      </tr>
                                    @endforeach
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
@endsection