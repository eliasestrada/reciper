@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="container profile-header">
	<div>
		<h1>{{ $user->name }}</h1>
		<p>@lang('users.joined'): {{ facebookTimeAgo($user->created_at) }}</p>
		<p>
			{!! getOnlineIcon(facebookTimeAgo($user->updated_at)) !!}
			@lang('date.online') 
			{{ facebookTimeAgo($user->updated_at, 'online') }}
		</p>
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
					{!! readableNumber($recipes->count()) !!}
				</span>
				@include('icons.book', ['scale' => '1430'])
			</div>
			<span>@lang('includes.recipes')</span>
		</div>
	</div>
</div>

{{--  All my recipes  --}}
@component('comps.list_of_recipes', ['recipes' => $recipes])
	@slot('no_recipes')
		@lang('users.this_user_does_not_have_recipes')
	@endslot
@endcomponent

@endsection