<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Be On Time') }}</title>
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
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
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
  @include('includes.header')
