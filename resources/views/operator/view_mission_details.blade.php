@extends('layouts.dashboard')
@section('content')
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider_bank {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider_bank:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider_bank {
  background-color: #d6fb04;
}

input:focus + .slider_bank {
  box-shadow: 0 0 1px #d6fb04;
}

input:checked + .slider_bank:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider_bank.round {
  border-radius: 34px;
}

.slider_bank.round:before {
  border-radius: 50%;
}
</style>
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.missions')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.mission.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agent_needed')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.vehicle_required')}}</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{$mission->total_hours}} {{__('dashboard.hours')}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.customer_name')}}</label>
                        <span class="form-control">{{ucfirst($mission->customer_details->first_name.' '.$mission->customer_details->last_name)}}</span>
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.intervention')}}</label>
                        <span class="form-control">{{__('dashboard.agents.'.$mission->intervention.'')}}</span>
                      </div>
					  @if($mission->intervention == 'Security_patrol' && isset($mission->repetitive_mission) && isset($mission->mission_finish_time) && !empty($mission->repetitive_mission) && !empty($mission->mission_finish_time))
						<div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.repetitive_mission')}}</label>
                        <span class="form-control">{{$mission->repetitive_mission}}</span>
                      </div>
					  <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.finish_time')}}</label>
                        <span class="form-control">{{$mission->mission_finish_time}}</span>
                      </div>
					  <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.time_intervel')}}</label>
                        <span class="form-control">{{$mission->time_intervel}} {{__('dashboard.hours')}}</span>
                      </div>
					  @endif
                      <!-- div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.status')}}</label>
                        <span class="form-control">{{Helper::get_mission_status($mission->status)}}</span>
                      </div -->
                      @if(isset($mission->start_date_time) && $mission->start_date_time!='')
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}}</span>
                      </div>
                      @endif
                      <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
                        <span class="form-control">{{$mission->description}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                @if(isset($mission->agent_details))
                <h3>{{__('dashboard.agents.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.name')}}</label>
                        <span class="form-control">{{ucfirst($mission->agent_details->username)}}</span>
                      </div>
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agents.type')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name_multiple($mission->agent_details->types)}}</span>
                      </div>
                    </div>
                    <div class="row">
                      @if(isset($mission->started_at) && $mission->started_at!="")
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.started_at')}}</label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->started_at)}}</span>
                      </div>
                      @endif
                      @if(isset($mission->ended_at) && $mission->ended_at!="")
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.ended_at')}} </label>
                        <span class="form-control">{{Helper::date_format_show('d/m/Y H:i:s',$mission->ended_at)}}</span>
                      </div>
                      @endif
                      @if($mission->status==5)
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.hours_taken')}} </label>
                        <span class="form-control">{{Helper::get_mission_hours($mission->started_at,$mission->ended_at)}}</span>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                @endif
				@if(isset($mission->upload_invoice) && $mission->payment_status == '2')
                <h3>{{__('dashboard.mission.upload_invoice')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>{{__('dashboard.payment.mission_amount')}}</th>
                                  <th>{{__('dashboard.payment.date')}}</th>
                                  <th>{{__('dashboard.mission.payment_status')}}</th>
                                  <th>Invoice paid</th>
                                  <th>{{__('dashboard.action')}}</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>{{$mission->amount}} <i class="fa fa-euro-sign"></i></td>
                              <td>{{date('d/m/Y H:i:s', strtotime($mission->created_at))}}</td>
                              <td>Bank transfer</td>
                              <td>
								<label class="switch">
								  <input type="checkbox" name="bank_transfer" data-status="invouce" value="{{$mission->id}}" @if($mission->invoice_status == '1') checked @endIf>
								  <span class="slider_bank round"></span>
								</label>
							  </td>
                              <td><a class="download" href="{{asset('upload_invoices/'.$mission->upload_invoice->invoice)}}" download>{{__('dashboard.download')}} </a></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
                @endif
                <h3>{{__('dashboard.payment.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>{{__('dashboard.payment.mission_amount')}}</th>
                                  <th>{{__('dashboard.payment.date')}}</th>
                                  <th>{{__('dashboard.payment.status')}}</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $i=0; @endphp
                            @forelse($mission->payments as $payment)
                            @php $i++; @endphp
                            <tr>
                              <td>{{$i}}.</td>
                              <td>{{$payment->amount}} <i class="fa fa-euro-sign"></i></td>
                              <td>{{date('d/m/Y H:i:s', strtotime($payment->created_at))}}</td>
                              <td>{{ucfirst($payment->status)}}</td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4">{{__('dashboard.no_record')}}</td>
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