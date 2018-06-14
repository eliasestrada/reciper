@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<div class="content text-center">
		<h1>{{ $user->name }}</h1>
		<p>@lang('users.joined'): {{ facebookTimeAgo($user->created_at) }}</p>
		<p>@lang('users.online'): {{ facebookTimeAgo($user->updated_at) }}</p>
	</div>

	<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />

	<div class="bubbles">
		<div class="mb-4 bubbles-block">
			<div class="bubble">
				<span class="number">
					{!! readableNumber($likes) !!}
				</span>
				@include('icons.heart', ['scale' => '50'])
			</div>
			<span>@lang('users.likes')</span>
		</div>
		<div class="mb-4 bubbles-block">
			<div class="bubble">
				<span class="number">
					{!! readableNumber(getRatingNumber($recipes, $likes)) !!}
				</span>
				@include('icons.trophy', ['scale' => '50'])
			</div>
			<span>@lang('users.rating')</span>
		</div>
		<div class="bubbles-block">
			<div class="bubble">
				<span class="number">
					{!! readableNumber(99900) !!}
				</span>
				@include('icons.trophy', ['scale' => '50'])
			</div>
			<span>some text</span>
		</div>
	</div>
</div>

{{--  All my recipes  --}}
@component('comps.list_of_recipes', ['recipes' => $recipes])
	@slot('title')
		@lang('users.all_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.this_user_does_not_have_recipes')
	@endslot
@endcomponent

@endsection