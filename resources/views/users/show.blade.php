@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<h1>{{ $user->name }}</h1>
	<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
	<p class="content center">@lang('users.online'): {{ facebookTimeAgo($user->updated_at) }}</p>
</div>

<div class="container">
	{{--  All my recipes  --}}
	<div class="list-of-recipes">
		<p class="content center">@lang('users.all_recipes'): {{ $recipes->count() }}</p>

		@forelse ($recipes as $recipe)
			<div class="each-recipe" data-updated="@lang('users.date') {{ facebookTimeAgo($recipe->created_at) }}" data-author="@lang('users.status'): {{ $recipe->approved === 1 ? trans('users.checked') : trans('users.not_checked') }}">

				<a href="/recipes/{{ $recipe->id }}">
					<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="@lang('users.go_to_recipe')">
				</a>

				<div class="each-content">
					<span>{{ $recipe->title }}</span>
					<span>{{ $recipe->intro }}</span>
				</div>
			</div>
		@empty
			<p class="content center">@lang('users.this_user_does_not_have_recipes')</p>
		@endforelse

		{{ $recipes->links() }}
	</div>
</div>

@endsection