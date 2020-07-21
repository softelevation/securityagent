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
					<p class="version-class">Version: {{ Helper::project_text('version') }}</p>
                    <h3>{{__('frontend.text_86')}}</h3>
                </div>

                <div class="div_body">
                  <form id="general_form" method="post" action="{{url('/login')}}">
                    @csrf
                    <div class="form-group">
                      <input type="text" name="email" placeholder="{{__('frontend.text_87')}}" class="form-control" >
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" placeholder="{{__('frontend.text_88')}}" class="form-control" >
                    </div>
                    <div class="form-group mt-4">
                      <button type="submit" class="yellow_btn"> {{__('frontend.text_89')}}</button>
                    </div>
                    <div class="help">
                      Forgot Your Password ? 
                      <a href="{{ url('reset-password') }}">Get Help</a>
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