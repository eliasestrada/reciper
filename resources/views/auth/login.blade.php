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

		<label for="email">@lang('form.email')</label>
		<input type="email" name="email" placeholder="@lang('form.email')">
	</div>

	<div class="form-group simple-group">
		<label for="password">@lang('form.pwd')</label>
		<input type="password" name="password" placeholder="@lang('form.pwd')">
	</div>
	
	<div class="form-group simple-group mt-3 d-flex">
		<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('form.remember_me')
	</div>

	<div class="form-group simple-group">
		<button type="submit" id="go-to-account" class="btn btn-lg btn-main">
			@lang('form.login')
		</button>
	</div>

	{{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
</form>

@endsection
