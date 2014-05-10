@extends('layouts.front')

{{-- Page title --}}
@section('title')
Forgot Password ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>{{ Lang::get('auth.lost_password') }}</h3>
	{{ Form::open(array('role' => 'form')) }}

	 <div class="form-group">
		{{ Form::label('password', Lang::get('auth.password')) }}
    {{ Form::password('password', array('class' => 'form-control')) }}
    {{ $errors->first('password', ':message') }}
	</div>

	 <div class="form-group">
		{{ Form::label('password_confirm', Lang::get('auth.password_confirm')) }}
    {{ Form::password('password_confirm', array('class' => 'form-control'))) }}
    {{ $errors->first('password_confirm', ':message') }}
	</div>

  <button type="submit" class="btn btn-default">{{ Lang::get('auth.submit') }} </button>
	
  {{ Form::close() }}

@stop
