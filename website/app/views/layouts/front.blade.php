<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
  @section('title')
  ( . )( . )
  @show
  </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
  <link rel="stylesheet/less" type="text/css" href="{{ asset('assets/less/bootstrap.less') }}">
  @yield('css')
</head>
<body>
  @include('layouts.notifications')
  @include('layouts.header')
  @yield('content')


  {{ HTML::script('assets/js/vendor/jquery.min.js'); }}
  {{ HTML::script('assets/js/vendor/bootstrap.min.js'); }}
  {{ HTML::script('assets/js/less-1.7.0.min.js'); }}
  {{ HTML::script('assets/js/front.js'); }}
  @yield('js')

</body>

</html>
