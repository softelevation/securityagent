@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Missions</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>Mission Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Mission Title</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Ref.</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Location</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Agent Type Needed</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Hours</label>
                        <span class="form-control">{{$mission->total_hours}} Hour(s)</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Mission Status</label>
                        <span class="form-control">@if($mission->status==0) Unverified @else {{Helper::getMissionStatus($mission->status)}} @endif</span>
                      </div>
                      <div class="col-md-12 form-group">
                        <label>Mission Description</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                      @if(isset($mission->start_date_time) && $mission->start_date_time!='')
                      <div class="col-md-6 form-group">
                        <label>Mission Start Date Time</label>
                        <span class="form-control">{{date('m/d/Y H:i:s', strtotime($mission->start_date_time))}}</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                @if(isset($mission->agent_details))
                <h3>Agent Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Agent Name</label>
                        <span class="form-control">{{ucfirst($mission->agent_details->username)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Agent Type</label>
                        <span class="form-control">{{Helper::get_agent_type_name_multiple($mission->agent_details->types)}}</span>
                      </div>
                    </div>
                    <div class="row">
                      @if(isset($mission->started_at) && $mission->started_at!="")
                      <div class="col-md-6 form-group">
                        <label>Mission Started At</label>
                        <span class="form-control">{{Helper::date_format_show('m/d/Y H:i:s',$mission->started_at)}}</span>
                      </div>
                      @endif
                      @if(isset($mission->ended_at) && $mission->ended_at!="")
                      <div class="col-md-6 form-group">
                        <label>Mission Ended At </label>
                        <span class="form-control">{{Helper::date_format_show('m/d/Y H:i:s',$mission->ended_at)}}</span>
                      </div>
                      @endif
                      @if($mission->status==5)
                      <div class="col-md-6 form-group">
                        <label>Total Hours Taken By Agent </label>
                        <span class="form-control">{{Helper::get_mission_hours($mission->started_at,$mission->ended_at)}}</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
                <h3>Payment Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Mission Amount</th>
                                  <th>Patment Date</th>
                                  <th>Payment Status</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $i=0; @endphp
                            @forelse($mission->payments as $payment)
                            @php $i++; @endphp
                            <tr>
                              <td>{{$i}}.</td>
                              <td>{{$payment->amount}} <i class="fa fa-euro-sign"></i></td>
                              <td>{{date('m/d/Y H:i:s', strtotime($payment->created_at))}}</td>
                              <td>{{ucfirst($payment->status)}}</td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">No payment records</td>
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
@endsection