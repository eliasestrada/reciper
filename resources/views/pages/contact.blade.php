@extends('layouts.app')

@section('title', trans('pages.feedback'))

@section('content')

<div class="page container">
	<div class="center"><h1 class="headline">@lang('pages.feedback')</h1></div>

	@if (session('success'))
		<div class="center mt-4">
			@include('includes.buttons.home-btn') <br />
			@include('includes.buttons.help-btn')
		</div>
	@else
		<p>@lang('contact.intro')</p>
		<form action="{{ action('ContactController@store') }}" method="post">
			<div class="input-field"> @csrf
				<i class="material-icons prefix">email</i>
				<input type="email" name="email" value="{{ old('email') }}" id="email">
				<label for="email">@lang('form.email')</label>
				<span class="helper-text">@lang('form.email_desc')</span>
			</div>
			<div class="input-field">
				<i class="material-icons prefix">comment</i>
			<textarea name="message" id="message" class="materialize-textarea counter" data-length="{{ config('validation.contact_message') }}">{{ old('message') }}</textarea>
				<label for="message">@lang('form.message')</label>
				<span class="helper-text">@lang('form.message_desc')</span>
			</div>
			<div class="input-field">
				<button type="submit" class="btn btn-main">
					<i class="material-icons right">send</i>
					@lang('form.send')
				</button>
			</div>
		</form>
	@endif
</div>

@endsection

@section('script')
	@include('includes.js.counter')
@endsection