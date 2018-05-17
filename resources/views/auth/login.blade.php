@extends('layouts.app')

@section('title', trans('form.login'))

@section('content')

<form method="POST" action="{{ route('login') }}" class="form">

	@csrf

	<div class="form-group simple-group">
		<h2 class="form-headline">
			<i class="title-icon" style="background: url('/css/icons/svg/user.svg')"></i>
			@lang('form.login')
		</h2>

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
		{{ Form::submit(trans('form.login'), ['id' => 'go-to-account']) }}
	</div>

	{{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
</form>
<div class="spacer"></div>

@endsection
