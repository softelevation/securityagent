@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.report.report')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">{{__('dashboard.report.report')}} </a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <div class="pending-details">
                        <div class="view_agent_details mt-4">
                          {{Form::open(['id'=>'general_form','url'=>url('operator/report')])}}
                          <div class="row">							
							<div class="col-md-2 form-group">
                              <label>Select Agent : </label>
                            </div>
                            <div class="col-md-6 form-group">
                              {{Form::select('first_name',$agent,null,['class'=>'form-control','placeholder'=>'Select agent'])}}
                            </div>
							
                          </div>
                          <div class="row">
                            <div class="col-md-2 form-group">
                              <label>Period : </label>
                            </div>
                            <div class="col-md-6 form-group">
                              {{Form::text('home_address',null,['class'=>'form-control','placeholder'=>'Your home address'])}}
                            </div>
                          </div>
						  
						  <div class="row">
                            <div class="col-md-2 form-group">
                              <label>Formet : </label>
                            </div>
                            <div class="col-md-2 form-group">
                              {{Form::radio('formet',1,true)}} PDF
                            </div>
							<div class="col-md-2 form-group">
                              {{Form::radio('formet',3,false)}} EXCEL
                            </div>
                          </div>
						  
                          <div class="row">
                            <div class="col-md-6 text-center">
                                  <button type="submit" class="button success_btn">Submit</button>
                            </div>
                        </div>
                          {{Form::close()}}
                        </div>
                      </div>
                    </div>
                    <!-- Missions in progress tab -->
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