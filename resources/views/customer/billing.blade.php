@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.billing')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.billings.heading')}} </a>
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
                                          <th>{{__('dashboard.mission.ref')}}</th>
                                          <th>{{__('dashboard.billings.amount_charged')}}</th>
                                          <th>{{__('dashboard.status')}}</th>
                                          <th>{{__('dashboard.billings.date_time')}}</th>
                                          <th>{{__('dashboard.action')}}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php 
                                      $i = 0;
                                    @endphp
                                    @forelse($history as $data)
                                      @php $i++; @endphp
                                      <tr>
                                          <td>{{$i}}.</td>
                                          <td>{{$data->title}}</td>
                                          <td>{{Helper::mission_id_str($data->mission_id)}}</td>
                                          <td>{{$data->amount}} <i class="fa fa-euro-sign"></i></td>
                                          <td>@if($data->status == 'succeeded') {{__("frontend.$data->status")}} @else {{__("frontend.$data->status")}}  @endif</td>
                                          <td>{{date('d/m/Y H:i:s', strtotime($data->created_at))}}</td>
                                          <td><a class="action_icons" href="{{url('download-payment-receipt/'.Helper::encrypt($data->mission_id))}}"><i class="fa fa-download"></i> {{__('dashboard.download')}}</a></td>
                                      </tr>
                                    @empty
                                      <tr>
                                          <td colspan="5">{{__('dashboard.no_record')}} !</td>
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