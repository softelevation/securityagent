@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.billing')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
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
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                    @forelse($history as $data)
                                      @php $i++; @endphp
                                      <tr>
                                          <td>{{$i}}.</td>
                                          <td>{{$data->mission_details->title}}</td>
                                          <td>{{Helper::mission_id_str($data->mission_details->id)}}</td>
                                          <td>{{$data->amount}} <i class="fa fa-euro-sign"></i></td>
                                          <td>{{$data->status}}</td>
                                          <td>{{date('d/m/Y H:i:s', strtotime($data->created_at))}}</td>
                                          <td><a target="_blank" class="action_icons" href="{{url('download-payment-receipt/'.Helper::encrypt($data->id))}}"><i class="fa fa-download"></i> {{__('dashboard.download')}}</a></td>
                                      </tr>
                                    @empty
                                      <tr>
                                          <td colspan="7">{{__('dashboard.no_record')}} !</td>
                                      </tr>
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <div class="row">
                            <div class="ml-auto mr-auto">
                              <nav class="navigation2 text-center" aria-label="Page navigation">
                                {{$history->links()}}
                              </nav>
                            </div>
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