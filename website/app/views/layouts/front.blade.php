<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="UTF-8">
  <title>
  @section('title')
  Unefille
  @show
  </title>
  <meta name="viewport" content="initial-scale=1.0, width=device-width" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{ HTML::style('assets/css/vendor/bootstrap.min.css')}}
  @yield('css')
</head>
<body>

 <div class="container">
    @include('layouts.notifications')
    @yield('content')
  </div>

  {{ HTML::script('assets/js/vendor/jquery.min.js'); }}
  {{ HTML::script('assets/js/vendor/bootstrap.min.js'); }}
  {{ HTML::script('assets/js/front.js'); }}
  @yield('js')

</body>

</html>
