@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div>
                  <h2>Customers</h2>
              </div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a class="nav-link active">All Customer List View </a>
                      </li>
                  </ul>
                  <div>
                      <div>
                          <div class="table-responsive">
                              <table class="table table-hover table-striped">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Customer Name</th>
                                          <th>Customer Type</th>
                                          <th>E-mail Address</th>
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
                                            <a class="action_icons" href="{{url('operator/customer/view/'.$en_id)}}"><i class="fas fa-eye text-grey" aria-hidden="true"></i> View details</a>
                                          </td>
                                      </tr>
                                    @empty
                                      <tr>
                                          <td colspan="5">No record found !</td>
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