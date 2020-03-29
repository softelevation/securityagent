@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Refund Mission</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>Payment Details</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Mission Ref.</th>
                                  <th>Mission Amount</th>
                                  <th>Patment Date</th>
                                  <th>Payment Status</th>
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
                              <td>{{date('m/d/Y H:i:s', strtotime($payment->created_at))}}</td>
                              <td>{{ucfirst($payment->status)}}</td>
                              <td>
                                @if($payment->refund_status=='succeeded')
                                  <span style="padding: 0px 5px; font-size: 14px;" type="button" class="btn btn-outline-success">Refunded</span>
                                @else
                                  <a id="{{$payment->charge_id}}" href="javascript:void(0)" class="btn_submit refund_now_btn"> Refund</a>
                                @endif
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="6">No payment records</td>
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