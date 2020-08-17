@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">

      @if ( session()->has('message_success'))
          <div class="alert alert-info" role="alert">
              <a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>
              {{ session()->get('message_success') }}
          </div>
      @endif

        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.message_center')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.payment.message_center_heading')}} </a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- Pending Agents -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('dashboard.customer_name')}}</th>
                                    <th>{{__('dashboard.email')}}</th>
                                    <th>{{__('dashboard.from')}}</th>
                                    <th>{{__('dashboard.status')}}</th>
                                    <th>{{__('dashboard.billings.date_time')}}</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
							@php $i = 1; @endphp
                              @foreach($message_center as $message)
                                <tr> 
                                    <td>{{ $i }}</td>
									@if($message->message_type === 'send_by_cus')
										<td>{{ucfirst($message->first_name)}} {{ucfirst($message->last_name)}}</td>
									@else
										<td>{{ucfirst($message->a_first_name)}} {{ucfirst($message->a_last_name)}}</td>
									@endif
                                    <td>{{$message->email}}</td>
                                    <td>@if($message->message_type=='send_by_cus') Customer @else Agent @endif</td>
                                    <td>{{($message->status == '1') ? 'on':'close' }}</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($message->created_at))}}</td>
                                    <td><a href="{{url('operator/message-center')}}/{{ $message->user_id }}" class="action_icons"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a></td>
                                </tr>
							@php $i++; @endphp
                              @endforeach
                            </tbody>
                        </table>
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
{{Form::open(['url'=>url('operator/block-unblock-agent'),'id'=>'general_form'])}}
{{Form::hidden('agent_id',null,['id'=>'agent_id'])}}
{{Form::hidden('type',null,['id'=>'type'])}}
{{Form::close()}}
@endsection
