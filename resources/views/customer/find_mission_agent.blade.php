@extends('layouts.dashboard')
@section('content')
<div class="profile">
      @if($errors->any())
        <div class="alert alert-info" style="text-align:center">
          <strong>{{$errors->first()}}</strong>
        </div>
      @endif

    <div class="container">
        <div class="row"> 
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.mission')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
				  <a href="javascript:void(0)" onclick="printmissionDiv()" class="button success_btn mission_print_save">Print</a>
                  <a href="{{url('customer/save-pdf-proceed-payment/')}}/{{Helper::encrypt($mission->id)}}" class="button success_btn mission_print_save">Save</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box" id="DivIdToPrint">
                <h3>{{__('dashboard.mission.summary')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
                        <span class="form-control">{{$mission->title}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.mission.ref')}}</label>
                        <span class="form-control">{{Helper::mission_id_str($mission->id)}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
                        <span class="form-control">{{$mission->location}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agent_needed')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name($mission->agent_type)}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.vehicle_required')}}</label>
                        <span class="form-control">{{Helper::vehicle_required_status($mission->vehicle_required)}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        <span class="form-control">{{$mission->total_hours}} Hour(s)</span>
                      </div>
                      @if($mission->quick_book==0)
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.mission.start_time')}}</label>
                        <span class="form-control">{{date('d/m/Y H:i:s', strtotime($mission->start_date_time))}}</span>
                      </div>
                      @endif
					  <div class="col-md-12 form-group">
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
                        <span class="form-control">{{$mission->time_intervel}}</span>
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
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.name')}}</label>
                        <span class="form-control">{{ucfirst($mission->agent_details->username)}}</span>
                      </div>
                      <div class="col-md-4 form-group">
                        <label>{{__('dashboard.agents.type')}}</label>
                        <span class="form-control">{{Helper::get_agent_type_name_multiple($mission->agent_details->types)}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                <h3>{{__('dashboard.payment.details')}}</h3>
                @php 
                  $vat_amount = Helper::get_vat_amount($mission->amount,$mission->vat);
                  $original_amount = $mission->amount-$vat_amount;
                @endphp
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                          <tbody>
                            <tr>
                              <td width="50%" class="text-right">{{__('dashboard.payment.total')}}:</td>
                              <td class="text-left">{{$original_amount}} <i class="fa fa-euro-sign"></i></td>
                            </tr>
                            <tr>
                              <td class="text-right">{{__('dashboard.vat')}} ({{Helper::VAT_PERCENTAGE}}%)</td>
                              <td class="text-left">{{$vat_amount}} <i class="fa fa-euro-sign"></i></td>
                            </tr>
                            <tr>
                              <th class="text-right">{{__('dashboard.payment.total_mission_amount')}}</th>
                              <th class="text-left">{{$mission->amount}} <i class="fa fa-euro-sign"></i></th>
                            </tr>
                            @if($mission->quick_book==0)
                            <tr>
                              <th class="text-right">{{__('dashboard.payment.total_charge_amount')}}</th>
                              <th class="text-left">{{$charge_amount}} <i class="fa fa-euro-sign"></i></th>
                            </tr>
                            @endif
                          </tbody>
                        </table>
                    </div>
                    @if($mission->quick_book==0)
                    <div class="text-center">
                      <small class="note-div">{{__('dashboard.payment.note_30')}}</small>
                    </div>
                    @endif
                  </div>
                  <div class="text-center">
					<div class="text-center pt-5 text_panel">
						<input type="checkbox" class="checkbox1" name="terms_conditions_find_mission" value="1">{!! trans('frontend.term_and_condition_1') !!}</br>
						<input type="checkbox" class="checkbox2" name="terms_conditions_find_mission" value="2">{!! trans('frontend.term_and_condition_2') !!}</br>
					</div>
							
                    <a href="{{url('customer/proceed-payment/')}}/{{Helper::encrypt($mission->id)}}" class="button success_btn proceed_success_btn disabled">{{__('dashboard.payment.proceed')}}</a>
                    
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
