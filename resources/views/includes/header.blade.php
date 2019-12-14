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
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
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
<div id="Header">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="{{asset('assets/images/logo.jpg')}}"/></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="main_menu">
            <div class="menu_left">
                <div class="top_menu">
                    <ul>
                        <li><a href="">Login</a></li> <em>|</em>  <li><a href="">Registration</a></li>
                        <li><div class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/images/usa_flag.png')}}"/> USA
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">USA</a></li>
                            <li><a href="#">Australia</a></li>
                            <li><a href="#">India</a></li>
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
                <a type="button" data-toggle="modal" data-target="#become_agent">Become an Agent</a>
            </div>
        </div>
      </div>
    </div>
  </nav>
</div>