@extends('layouts.front')

@section('title')
Account Sign up ::
@parent
@stop

@section('content')
    {{ Form::open(array('route' => 'signup', 'role' => 'form')) }}
      <!-- First Name -->
      <div class="form-group">
        {{ Form::label('first_name', Lang::get('auth.firstname') )}}
        {{ Form::text('first_name', '', array('class' => 'form-control'))}}
        {{ $errors->first('first_name', ':message') }}
      </div>
      <!-- company_name -->
     <div class="form-group">
        {{ Form::label('last_name', Lang::get('auth.lastname') )}}
        {{ Form::text('last_name', '', array('class' => 'form-control')) }}
        {{ $errors->first('last_name', ':message') }}
      </div>
      <!-- Email -->
      <div class="form-group">
        {{ Form::label('email', 'E-mail') }}
        {{ Form::text('email', '', array('class' => 'form-control')) }}
        {{ $errors->first('email', ':message') }}
      </div>
      <!-- Password -->
      <div class="form-group">
        {{ Form::label('password', Lang::get('auth.password')) }}
        {{ Form::password('password', array('class' => 'form-control')) }}
        {{ $errors->first('password', ':message') }}
      </div>

      <button type="submit" class="btn btn-default">{{ Lang::get('auth.signup_button') }} </button>

    {{ Form::close() }}
  
  </div>

@stop
