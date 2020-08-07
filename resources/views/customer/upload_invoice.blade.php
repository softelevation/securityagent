@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.customer_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>{{__('dashboard.mission.upload_invoice')}}</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> {{__('dashboard.back')}}</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-100">
                          <a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">{{__('dashboard.mission.upload_invoice')}}</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <div class="pending-details">
                        <div class="view_agent_details mt-4">
                          {{Form::open(['url'=>url('customer/upload-invoice'),'id'=>'upload_invoice_mission','enctype'=>'multipart/form-data'])}}
                          <div class="row">
							<input type="hidden" name="mission_id" value="{{$id}}" />
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>{{__('dashboard.mission.upload_invoice')}}</label><br>
                                <div class="custom-file">
                                  <input type="file" name="upload_invoice" class="custom-file-input" id="profilePicImage"/>
                                  <label class="custom-file-label" for="profilePicImage">{{__('dashboard.upload_documents')}}</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 text-center">
                                  <button type="submit" class="button success_btn">{{__('dashboard.mission.save_invoice')}}</button>
                            </div>
                        </div>
                          {{Form::close()}}
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