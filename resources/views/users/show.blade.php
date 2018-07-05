@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<div>
		<h1 class="my-4">{{ $user->name }}</h1>
		<p>@lang('users.joined'): {{ timeAgo($user->created_at) }}</p>
		@unless (user() && $user->id === user()->id)
			<p>
				{!! getOnlineIcon(timeAgo($user->last_visit_at)) !!}
				@lang('date.online') 
				{{ timeAgo($user->last_visit_at, 'online') }}
			</p>
		@endunless
	</div>

	<div class="image-wrapper">
		<img src="{{ asset('storage/users/'.$user->image) }}" alt="{{ $user->name }}" />
	</div>

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
@listOfRecipes(['recipes' => $recipes])
	@slot('no_recipes')
		@lang('users.this_user_does_not_have_recipes')
	@endslot
@endlistOfRecipes

@endsection