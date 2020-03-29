@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Payment Approvals</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">All Mission's Extra Payment Approvals </a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                              <table class="table table-hover table-striped">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Mission Title</th>
                                          <th>Mission Ref.</th>
                                          <th>Customer Name</th>
                                          <th>Amount</th>
                                          <th>Mission End Time</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php 
                                      $i = 0; 
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                    @forelse($payments as $data)
                                      @php $i++; @endphp
                                      <tr>
                                          <td>{{$i}}.</td>
                                          <td>{{$data->mission_details->title}}</td>
                                          <td>{{Helper::mission_id_str($data->mission_details->id)}}</td>
                                          <td>{{ucfirst($data->customer_details->first_name)}} {{ucfirst($data->customer_details->last_name)}}</td>
                                          <td>{{$data->amount}} <i class="fa fa-euro-sign"></i></td>
                                          <td>{{date('m/d/Y H:i:s', strtotime($data->created_at))}}</td>
                                          <td>
                                            <div class="dropdown">
                                              <a class="action_icons dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-list text-grey" aria-hidden="true"></i> Actions</a>
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{url('operator/mission-details/view')}}/{{Helper::encrypt($data->mission_id)}}" class="dropdown-item"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View Details</a>
                                            
                                                <a href="javascript:void(0)" data-type="1" data-record-id="{{Helper::encrypt($data->id)}}" class="dropdown-item pa_act_btn"><i class="fas fa-check text-grey" aria-hidden="true"></i> Approve Payment</a>

                                                <a href="javascript:void(0)" data-type="2" data-record-id="{{Helper::encrypt($data->id)}}" class="dropdown-item pa_act_btn"><i class="fas fa-times text-grey" aria-hidden="true"></i> Reject Payment</a>
                                              </div>
                                            </div>
                                          </td>
                                      </tr>
                                    @empty
                                      <tr>
                                          <td colspan="7">No record found !</td>
                                      </tr>
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <div class="row">
                            <div class="ml-auto mr-auto">
                              <nav class="navigation2 text-center" aria-label="Page navigation">
                                {{$payments->links()}}
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
{{Form::open(['url'=>url('operator/payment-approval-action'),'id'=>'general_form'])}}
{{Form::hidden('record_id',null,['id'=>'p_a_r_id'])}}
{{Form::hidden('type',null,['id'=>'p_a_type'])}}
{{Form::close()}}
@endsection