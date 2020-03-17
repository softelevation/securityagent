@extends('layouts.dashboard')
@section('content')
<div class="profile">
    <div class="container">
        <div class="row">
            @include('includes.operator_sidebar')
            <!-- /.col-md-4 -->
            <div class="col-md-9">
              <div class="float-left">
                  <h2>Profile</h2>
              </div>
              <div class="float-right pt-3">
                  <a class="back_btn" href="{{URL::previous()}}"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
              </div>
              <div class="clearfix"></div>
              <div class="tab-pane">
                <div class="border" id="myTabContent">
                  <ul class="nav nav-tabs">
                      <li class="nav-item w-50">
                          <a id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link active">Change Profile </a>
                      </li>
                      <li class="nav-item w-50">
                          <a id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-home" aria-selected="true" class="nav-link">Change Password</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="nav-tabContent">
                    <!-- All Missions -->
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <div class="pending-details">
                        <div class="view_agent_details mt-4">
                          {{Form::model($profile,['url'=>url('update-profile'),'id'=>'general_form'])}}
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>First Name</label>
                              {{Form::text('first_name',null,['class'=>'form-control','placeholder'=>'Your first name'])}}
                            </div>
                            <div class="col-md-6 form-group">
                              <label>Last Name</label>
                              {{Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Your last name'])}}
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>Phone Number</label>
                              {{Form::text('phone',null,['class'=>'form-control','placeholder'=>'Your phone number'])}}
                            </div>
                            <div class="col-md-6 form-group">
                              <label>Home Address</label>
                              {{Form::text('home_address',null,['class'=>'form-control','placeholder'=>'Your home address'])}}
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Profile Image</label><br>
                                <div class="custom-file">
                                  <input type="file" name="image" class="custom-file-input" id="profilePicImage"/>
                                  <label class="custom-file-label" for="profilePicImage">@if(isset($profile['image'])) {{$profile['image']}} @else Upload an image @endif</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 text-center">
                                  <button type="submit" class="button success_btn">Update Profile</button>
                            </div>
                        </div>
                          {{Form::close()}}
                        </div>
                      </div>
                    </div>
                    <!-- Missions in progress tab -->
                    <div class="tab-pane fade show" id="nav-password" role="tabpanel" aria-labelledby="nav-in-progress-tab">
                      <div class="pending-details">
                        <div class="view_agent_details mt-4">
                          {{Form::open(['url'=>url('update-password'),'id'=>'general_form_2'])}}
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>Current Password</label>
                              {{Form::password('current_password',['class'=>'form-control','placeholder'=>'Your current password'])}}
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>New Password</label>
                              {{Form::password('new_password',['class'=>'form-control','placeholder'=>'Your new password'])}}
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 form-group">
                              <label>Confirm Password</label>
                              {{Form::password('confirm_password',['class'=>'form-control','placeholder'=>'Confirm your  password'])}}
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12 text-center">
                                  <button type="submit" class="button success_btn">Update Password</button>
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