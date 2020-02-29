<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'On Time') }}</title>
  <!-- Bootstrap core CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/toaster.css')}}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
  <link href="{{asset('css/select2.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/datetimepicker/jquery.datetimepicker.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
  <style type="text/css">
    .pac-container{
        z-index: 9999;
    }
    .map_div{
      width: 100%;
      display: inline-block;
    }
  </style>
</head>
<body>
  <div id="preloader">
    <div id="loader"></div>
  </div>
<div id="Header">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('assets/images/logo.jpg')}}"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="main_menu">
            <div class="menu_left">
                <div class="top_menu">
                    <ul>
                        @if(\Auth::check())
                          <li>
                            <div class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown"><img class="rounded-circle" width="25" src="{{asset('avatars/dummy_avatar.jpg')}}"/> Logged In
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{url('login')}}">Dashboard</a></li>
                                <li><a href="{{url('logout')}}">Log Out</a></li>
                              </ul>
                            </div>
                          </li>
                        @else
                          <li><a href="{{url('/login')}}">Login</a></li> 
                        @endif
                        <em>|</em>  
                        <!-- <li><a href="">Registration</a></li> -->
                        <li><div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/images/usa_flag.png')}}"/> English
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">English</a></li>
                            <li><a href="#">French</a></li>
                          </ul>
                        </div></li>
                    </ul>
                </div>
                <div class="primary">
                    <ul>
                        <li><a class="@if(url()->current()==url('/')) active @endif" href="{{url('/')}}">Home</a></li>
                        <li><a class="@if(url()->current()==url('/available-agents')) active @endif" href="{{url('/available-agents')}}">Available Agent on Map</a></li>
                        <li><a class="@if(url()->current()==url('/contact-us')) active @endif" href="{{url('/contact-us')}}">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="menu_right">
              @if(\Auth::check())
                @if(\Auth::user()->role_id==2)
                  <div class="availability-section">
                    <!-- Notifications Dropdown -->
                    <div class="float-left dropdown pl-3 position-relative">
                      <div class="notification" data-toggle="dropdown">
                        <span @if(Helper::get_misison_request_count()==0) data-container="body" data-toggle="popover" data-placement="bottom" data-content="No new notification." data-html="true" data-trigger="hover" @endif><i class="fa fa-bell"></i></span>
                        @if(Helper::get_misison_request_count() > 0)
                          <span class="badge">{{Helper::get_misison_request_count()}}</span>
                        @endif
                      </div>
                      @if(Helper::get_misison_request_count() > 0)
                      <ul class="dropdown-menu mission-requests">
                        <li class="item"><a href="{{url('agent/mission-requests')}}"><i class="fa fa-edit"></i> {{Helper::get_misison_request_count()}} New mission request</a></li>
                      </ul>
                      @endif
                    </div>
                    <!-- Availability -->
                    <div class="float-right">
                      <span class="pr-3">Availability</span> 
                      <label class="switch">
                        <input 
                        @if(\Auth::user()->agent_info->available==2) disabled="disabled" @endif 
                        type="checkbox" id="availability_check_btn" class="check" 
                        @if(\Auth::user()->agent_info->available==1) checked @endif>
                        <span 
                        @if(\Auth::user()->agent_info->available==2) 
                        data-container="body" data-toggle="popover" data-placement="bottom" data-content="During ongoing mission, availability status can't be changed." data-html="true" data-trigger="hover" @endif class="slider round"></span>
                      </label>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                @endif
              @else
                <a href="{{url('/register-agent-view')}}">Become an Agent</a>
                <a href="{{url('/customer-signup')}}">Become an User</a>
              @endif
            </div>  
        </div>
      </div>
    </div>
  </nav>
</div>