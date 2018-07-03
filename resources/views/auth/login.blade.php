@extends('layouts.app')

@section('title', trans('form.login'))

@section('content')

<div class="container py-5 px-3">
	<form method="POST" action="{{ route('login') }}" class="form">

		@csrf <div class="center"><h3 class="headline">@lang('form.login')</h3></div>
	
		<div class="input-field">
			<input id="email" type="email" name="email" placeholder="@lang('form.email')" class="validate">
			<label for="email">@lang('form.email')</label>
		</div>
	
		<div class="input-field">
			<input type="password" name="password" id="password" placeholder="@lang('form.pwd')" class="pwd">
			<label for="password">@lang('form.pwd')</label>
		</div>

		<div class="mt-3">
			<label>
				<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
				<span>
					@lang('form.remember_me') 
					@include('includes.tip', ['tip' => trans('form.remember_info')])
				</span>
			</label>
		</div>
	
		<div class="input-field">
			<button type="submit" id="go-to-account" class="btn btn-lg btn-main">
				<i class="material-icons right">keyboard_arrow_right</i>
				@lang('form.login')
			</button>
		</div>

		{{-- @TODO: --}}
		{{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
	</form>
	<div class="pt-4">
		<p>
			@lang('messages.dont_have_account'):
			<a href="/register">
				<span class="new badge p-1 px-2" style="float:none">@lang('form.register')</span>
			</a>
		</p>
	</div>
</div>

@endsection
