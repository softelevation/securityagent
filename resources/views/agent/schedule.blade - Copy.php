@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.agent_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Schedule</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  {{Form::model($schedule,['url'=>url('agent/save-schedule'),'id'=>'general_form'])}}
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>Available From</th>
                                    <th>Available To</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                              @php $days = Helper::week_days(); @endphp
                              @foreach($days as $key => $val)
                              <tr>
                                  <td>{{$key}}</td>
                                  <td>{{$val}}</td>
                                  <td>{{Form::text(strtolower($val).'_from',null,['class'=>'timepicker','id'=>'from_'.$key])}}</td>
                                  <td>{{Form::text(strtolower($val).'_to',null,['class'=>'timepicker','id'=>'to_'.$key])}}</td>
                                  <!-- <td>
                                    <input class="day_off_field" type="hidden" name="{{strtolower($val).'_off'}}" value="@if(isset($schedule[strtolower($val).'_off'])){{$schedule[strtolower($val).'_off']}}@else 0 @endif">
                                    <a href="#" class="action_icons day_off"><i class="fa fa-ban"></i> Disable</a>
                                    <a href="#" class="action_icons day_on d-none"><i class="fa fa-check"></i> Enable</a></td> -->
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                    <div class="row">
                      <div class="col-md-12 text-center pb-3">
                        <button class="button success_btn"><i class="fa fa-check"></i> Save Schedule</button>
                      </div>
                    </div>
                    {{Form::close()}}
                  </div>
              </div>
            </div>
            <!-- /.col-md-8 -->
        </div>

    </div>
    <!-- /.container -->
</div>
@endsection