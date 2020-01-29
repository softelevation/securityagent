@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row">    
        <div class="col-md-12">
            <div class="contact_box">
                <h3> View Agent Details</h3>
                <div class="profile_detail_box">
                  <div class="row p-4">
                    <div class="col-md-2 text-center">
                      <div>
                        <img class="rounded-circle avatar-image" src="{{asset('avatars/'.$agent->avatar_icon)}}">
                      </div>
                      <div class="pt-3">
                        <img src="{{asset('assets/images/star.jpg')}}">
                      </div>
                    </div>
                    <div class="col-md-10">
                      <div class="">
                        <h4>{{$agent->username}}</h4>
                        <hr>
                        <h6>{{Helper::get_agent_type_name_multiple($agent->types)}}</h6>
                        <p>@if($agent->is_vehicle==1) With Vehicle @else Without Vehicle @endif</p>
                      </div>
                      <div class="mt-4">
                        <h3> Agent Documents</h3>
                        <div class="row document-details">
                          @if($agent->identity_card)
                          <a href="{{asset('agent/documents/'.$agent->identity_card)}}" target="_blank" class="col-md-2 text-center hover-box">
                            <i class="fas fa-file"></i> Identity Card
                          </a>
                          @endif
                          @if($agent->social_security_number)
                          <a href="{{asset('agent/documents/'.$agent->social_security_number)}}" target="_blank" class="col-md-2 text-center hover-box">
                            <i class="fas fa-file"></i> Security Number
                          </a>
                          @endif
                          @if($agent->cv)
                          <a href="{{asset('agent/documents/'.$agent->cv)}}" target="_blank" class="col-md-2 text-center hover-box">
                            <i class="fas fa-file"></i> Curriculam Vitae
                          </a>
                          @endif
                        </div>
                      </div>
                      <div class="">
                        <h3> Recent Reviews</h3>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>        
    </div>  
    </div>
</div>
@endsection