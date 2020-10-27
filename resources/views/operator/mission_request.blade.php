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
                                          <th>{{__('dashboard.mission.title')}}</th>
                                          <th>{{__('dashboard.mission.location')}}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php 
                                      $i = 0; 
                                      $records = $limit*($page_no-1);
                                      $i = $i+$records;
                                    @endphp
                                    @forelse($data as $custom_req)
                                      @php $i++; @endphp
                                      <tr>
                                          <td>{{$i}}.</td>
                                          <td>{{$custom_req->first_name}} {{$custom_req->last_name}}</td>
                                          <td>{{$custom_req->title}}</td>
                                          <td>{{$custom_req->location}}</td>
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