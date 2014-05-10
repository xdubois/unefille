@extends('layouts.front')

@section('content')

  <p> Hello ! <br />
    @if(Sentry::check()) 
      {{ Sentry::getUser()->email }}
      <a href="{{ route('logout') }}"> logout</a> <br />
    @else
      <a href="{{ route('signin') }}">  Sign in </a> <br />
      <a href="{{ route('signup') }}"> Sign up </a>
    @endif
  </p>
  
@stop