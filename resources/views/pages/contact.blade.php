@extends('layouts.app')

@section('title', trans('pages.feedback'))

@section('content')

<div class="page container">
	<div class="center-align"><h1 class="headline">@lang('pages.feedback')</h1></div>

	@unless (session('success'))
		<div class="center-align mt-4">
			<a href="/" title="@lang('contact.to_home_page')" class="btn waves-effect waves-light">
				@lang('contact.to_home_page')
			</a>
			<a href="/recipes" title="@lang('contact.new_recipes')" class="btn waves-effect waves-light">
				@lang('contact.new_recipes')
			</a>
			@include('includes.help-btn')
		</div>
	@else
		<form action="{{ action('ContactController@store') }}" method="post">
			<div class="input-field"> @csrf
				<i class="material-icons prefix">email</i>
				<label for="email">@lang('form.email')</label>
				<input type="email" name="email" id="email">
			</div>
			<div class="input-field">
				<i class="material-icons prefix">message</i>
				<textarea name="message" id="message" class="materialize-textarea counter" data-length="{{ config('validation.contact_message') }}"></textarea>
				<label for="message">@lang('form.message')</label>
			</div>
			<div class="input-field">
				<button type="submit" class="btn btn-main">@lang('form.send')</button>
			</div>
		</form>
	@endunless
</div>

@endsection

@section('script')
	@include('includes.js.counter')
@endsection