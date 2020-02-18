@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div>
                  <h2>Set Schedule</h2>
              </div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <div>
                      <div>

                          <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Day</th>
                                        <th>Available From</th>
                                        <th>Available To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @php $days = Helper::week_days(); @endphp
                                  @foreach($days as $key => $val)
                                  <tr>
                                      <td>{{$key}}</td>
                                      <td>{{$val}}</td>
                                      <td><input class=" timepicker" type="text" name="time_from"></td>
                                      <td><input class=" timepicker" type="text" name="time_to"></td>
                                      <td><a href="#" class="action_icons"><i class="fa fa-ban"></i> Set Day Off</a></td>
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