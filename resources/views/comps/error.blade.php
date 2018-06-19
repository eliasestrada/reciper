@extends('layouts.error')

@section('title', $title)

@section('content')

	<div class="d-flex pb-5" style="height:100vh; align-items:center; justify-content:center; flex-direction:column">
		<h2 class="mb-3 headline">{{ $error }}</h2>
		<h5 class="mb-3">{{ $title }}</h5>
		<p class="mb-3">{{ $slot }}</p>

		@if (! isset($btn))
			@include('includes.buttons.home-btn')
			@include('includes.buttons.help-btn')
		@endif
	</div>

@endsection