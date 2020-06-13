@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.payment.refund_mission')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.payment.details')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>{{__('dashboard.mission.ref')}}</th>
                                  <th>{{__('dashboard.payment.mission_amount')}}</th>
                                  <th>{{__('dashboard.payment.date')}}</th>
                                  <th>{{__('dashboard.payment.status')}}</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            @php $i=0; @endphp
                            @forelse($mission->payments as $payment)
                            @php $i++; @endphp
                            <tr>
                              <td>{{$i}}.</td>
                              <td>{{Helper::mission_id_str($mission->id)}}</td>
                              <td>{{$payment->amount}} <i class="fa fa-euro-sign"></i></td>
                              <td>{{date('d/m/Y H:i:s', strtotime($payment->created_at))}}</td>
                              <td>{{ucfirst($payment->status)}}</td>
                              <td>
                                @if($payment->refund_status=='succeeded')
                                  <span style="padding: 0px 5px; font-size: 14px;" type="button" class="btn btn-outline-success">{{__('dashboard.payment.refunded')}}</span>
                                @else
                                  <a id="{{$payment->charge_id}}" href="javascript:void(0)" class="btn_submit refund_now_btn"> {{__('dashboard.payment.refund')}}</a>
                                @endif
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="6">{{__('dashboard.no_record')}}</td>
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
{{Form::open(['url'=>url('operator/refund-mission-amount'),'id'=>'general_form'])}}
{{Form::hidden('mission_id',Helper::encrypt($mission->id))}}
{{Form::hidden('charge_id',null,['id'=>'charge_id'])}}
{{Form::close()}}
@endsection