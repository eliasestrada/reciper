@extends('layouts.app')

@section('title', trans('form.login'))

@section('content')

<h2 class="headline">@lang('form.login')</h2>
<form method="POST" action="{{ route('login') }}" class="form">

	@csrf

	<div class="form-group simple-group">
		{{ Form::label('email', trans('form.email')) }}
		{{ Form::email('email', null, ['placeholder' => trans('form.email')]) }}
	</div>

	<div class="form-group simple-group">
		{{ Form::label('password', trans('form.pwd')) }}
		{{ Form::password('password', ['placeholder' => trans('form.pwd')]) }}
	</div>
	
	<div class="form-group simple-group" style="display:flex;">
		<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('form.remember_me')
	</div>

	<div class="form-group simple-group">
		{{ Form::submit(trans('form.login')) }}
	</div>

	{{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
</form>
<div class="spacer"></div>

@endsection
