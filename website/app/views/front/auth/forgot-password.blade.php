@extends('layouts.front')

{{-- Page title --}}
@section('title')
Forgot Password ::
@parent
@stop

@section('content')
		<h3>{{ Lang::get('auth.lost_password') }}</h3>

	{{ Form::open(array('role' => 'form')) }}
	<!-- Email -->
   <div class="form-group">
		{{ Form::label('email', Lang::get('auth.email')) }}
    {{ Form::text('email','', array('class' => 'form-control')) }}
    {{ $errors->first('email', ':message') }}
	</div>
	<button type="submit" class="btn btn-default">{{ Lang::get('auth.submit') }} </button>
	{{ Form::close() }}
@stop
