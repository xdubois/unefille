@extends('layouts.front')

{{-- Page title --}}
@section('title')
Account Sign in ::
@parent
@stop

{{-- Page content --}}
@section('content')

  {{ Form::open(array('route' => 'signin', 'role' => 'form')) }}
    <!-- Email -->
    <div class="form-group">
      {{ Form::label('email', Lang::get('auth.email')) }}
      {{ Form::text('email', '', array('class' => 'form-control'))}}
      {{ $errors->first('email', ':message') }}
    </div>

    <!-- Password -->
    <div class="form-group">
      {{ Form::label('password', Lang::get('auth.password')) }}
      {{ Form::password('password', array('class' => 'form-control')) }}
      {{ $errors->first('password', ':message') }}
    </div>
    <button type="submit" class="btn btn-default">{{ Lang::get('auth.signin_button') }} </button>
  {{ Form::close() }}

   <p> <br />
      <a href="{{ route('forgot-password') }}" class="btn btn-link"> @lang('auth.lost_password')</a>
    </p>
    
  @stop
