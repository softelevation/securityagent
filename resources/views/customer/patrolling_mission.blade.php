@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.missions')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="contact_box">
                <h3>{{__('dashboard.patrolling_mission')}}</h3>
                <div class="pending-details">
                  <div class="view_agent_details mt-4">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.title')}}</label>
						{{Form::text('mission_title',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.title')])}}
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.location')}}</label>
						{{Form::text('mission_location',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.location')])}}
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.agent_needed')}}</label>
                        {{Form::text('agent_needed',null,['class'=>'form-control','placeholder'=>__('dashboard.agent_needed')])}}
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.mission_hours')}}</label>
                        {{Form::text('mission_hours',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.mission_hours')])}}
                      </div>
					  
					  
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.type')}}</label>
						{{Form::text('mission_ref',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.type')])}}
                      </div>
                      
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.time_interval')}}</label>
                        {{Form::text('time_interval',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.time_interval')])}}
                      </div>
                      
                      <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.start_date')}}</label>
                        {{Form::text('start_date',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.start_date')])}}
                      </div>
					  <div class="col-md-6 form-group">
                        <label>{{__('dashboard.mission.end_date')}}</label>
                        {{Form::text('end_date',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.end_date')])}}
                      </div>
					  
                      <div class="col-md-12 form-group">
                        <label>{{__('dashboard.mission.description')}}</label>
						{{Form::textarea('description',null,['class'=>'form-control','placeholder'=>__('dashboard.mission.description')])}}
                      </div>
					  
					  <div class="col-md-12 text-center">
                                  <button type="submit" class="button success_btn">{{__('dashboard.mission.book_agent_now')}}</button>
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