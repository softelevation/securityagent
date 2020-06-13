@extends('layouts.app')
@section('content')
<div class="banner">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
              <div class="login_form">
                <div class="login_inner">
                <div class="div_header">
                   <span class="lock-icon"><i class="fa fa-unlock"></i></span>
                    <h3>{{__('frontend.text_86')}}</h3>
                </div>
                <div class="div_body">
                  <form id="general_form" method="post" action="{{url('/set_new_password')}}">
                    @csrf
                    <input type="hidden" name="email_token" value="{{$token}}">
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" placeholder="{{__('frontend.text_136')}}" />
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm_password" class="form-control" placeholder="{{__('frontend.text_138')}}" />
                    </div>
                    <div class="form-group mt-4">
                      <button type="submit" class="yellow_btn"> {{__('frontend.reset_password_btn')}}</button>
                    </div>
                  </form>
                </div>
              </div>
                <div class="footer_login">
                  {{__('frontend.text_92')}} <a href="{{url('customer-signup')}}" class="register_btn yellow_btn">{{__('frontend.text_93')}}</a> 
                </div>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection