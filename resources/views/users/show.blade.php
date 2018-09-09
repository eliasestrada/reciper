@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="page profile-header">
	<div>
		<h1 class="my-4">{{ $user->name }}</h1>
		<p>@lang('users.joined'): {{ time_ago($user->created_at) }}</p>
		@unless (user() && $user->id === user()->id)
			<p>
				{!! get_online_icon(time_ago($user->last_visit_at)) !!}
				@lang('date.online') 
				{{ time_ago($user->last_visit_at, 'online') }}
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
					{!! readable_number($likes) !!}
				</span>
				@include('includes.icons.heart')
			</div>
			<span>@lang('users.likes')</span>
		</div>
		<div class="mb-4 bubbles-block">
			<div class="bubble">
				<span class="number">
					{!! readable_number(get_rating_number($recipes, $likes)) !!}
				</span>
				@include('includes.icons.trophy')
			</div>
			<span>@lang('users.rating')</span>
		</div>
		<div class="bubbles-block">
			<div class="bubble">
				<span class="number">
					{!! readable_number($recipes->count()) !!}
				</span>
				@include('includes.icons.book')
			</div>
			<span>@lang('includes.recipes')</span>
		</div>
	</div>
</div>

{{--  All my recipes  --}}
<div class="page">
	@listOfRecipes(['recipes' => $recipes])
		@slot('no_recipes')
			@lang('users.this_user_does_not_have_recipes')
		@endslot
	@endlistOfRecipes
</div>

@endsection