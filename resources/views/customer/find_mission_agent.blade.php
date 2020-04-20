@extends('layouts.dashboard')
@section('content')
<div class="profile">
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
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
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
                              <td class="text-right">VAT ({{Helper::VAT_PERCENTAGE}}%)</td>
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
                    <a href="{{url('customer/proceed-payment/')}}/{{Helper::encrypt($mission->id)}}" class="button success_btn">{{__('dashboard.payment.proceed')}}</a>
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