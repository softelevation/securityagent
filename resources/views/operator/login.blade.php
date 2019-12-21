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
                    <h3>Log In</h3>
                    <p>Become a Part of Our Agency</p>
                </div>

                <div class="div_body">
                  <form id="general_form" method="post" action="{{url('operator/operator_login')}}">
                    @csrf
                    <div class="form-group">
                      <input type="text" name="email" placeholder="Email Address" class="form-control" >
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" placeholder="Password" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label><input type="checkbox"> Remember Me</label>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="yellow_btn"> LOGIN</button>
                    </div>
                    <div class="help">
                      Forgot Your Password ? 
                      <a href="">Get Help</a>
                    </div>
                  </form>
                </div>
              </div>
                <div class="footer_login">
                  Not a Member? <button class="register_btn yellow_btn">Register</button> 
                </div>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection