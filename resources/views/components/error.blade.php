@extends('layouts.error')

@section('title', $title)

@section('content')

	<div style="height:100vh; display:flex; align-items:center; justify-content:center; flex-direction:column">
		<h2 style="margin-bottom:5px;">{{ $error }}</h2>
		<h2 style="margin-bottom:5px;">{{ $title }}</h2>
		<p style="margin-bottom:5px;">{{ $slot }}</p>
		@if (! isset($btn))
			<a href="/" class="button" title="@lang('errors.to_home')">
				@lang('errors.to_home')
			</a>
		@endif
	</div>

@endsection