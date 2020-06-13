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
                  <h2>{{__('dashboard.customers')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">{{__('dashboard.customer_heading')}} </a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                              <table class="table table-hover table-striped">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>{{__('dashboard.customer_name')}}</th>
                                          <th>{{__('dashboard.customer_type')}}</th>
                                          <th>{{__('dashboard.email')}}</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php 
                                      $i = 0; 
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                    @forelse($data as $customer)
                                      @php $i++; @endphp
                                      @php $en_id = Helper::encrypt($customer->id); @endphp
                                      <tr>
                                          <td>{{$i}}.</td>
                                          <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                          <td>{{Helper::get_customer_type_name($customer->customer_type)}}</td>
                                          <td>{{$customer->user->email}}</td>
                                          <td>
                                            <a class="action_icons" href="{{url('operator/customer/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> {{__('dashboard.view')}}</a></br>

                                            @if(Auth::user()->role_id == 3)
                                             <a class="action_icons" onclick="return confirm('Are you sure you want to delete?');" href="{{url('operator/customer/delete/'.$en_id)}}"> <i class="fa fa-trash" aria-hidden="true"></i> Delete </a>
                                            @endif

                                          </td>
                                      </tr>
                                    @empty
                                      <tr>
                                          <td colspan="5">{{__('dashboard.no_record')}} !</td>
                                      </tr>
                                    @endforelse
                                  </tbody>
                              </table>
                          </div>
                          <div class="row">
                            <div class="ml-auto mr-auto">
                              <nav class="navigation2 text-center" aria-label="Page navigation">
                                {{$data->links()}}
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