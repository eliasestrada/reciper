@extends('layouts.app')

@section('title', $user->name)

@section('content')

<div class="profile-header">
	<h1>{{ $user->name }}</h1>
	<img src="{{ asset('storage/uploads/'.$user->image) }}" alt="{{ $user->name }}" />
	<p class="content center">@lang('users.online'): {{ facebookTimeAgo($user->updated_at) }}</p>
</div>

{{--  All my recipes  --}}
<div class="item-list unstyled-list">
	<p class="content center">@lang('users.all_recipes'): {{ $recipes->count() }}</p>

	@forelse ($recipes as $recipe)
		<a href="/recipes/{{ $recipe->id }}" title="{{ $recipe->title }}">
			<li style="border-left:solid 3px #{{ $recipe->approved() ? '65b56e' : 'ce7777' }};">
				<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" />
				<div class="item-content">
					<h3 class="project-name">{{ $recipe->title }}</h3>
					<p class="project-title">
						@lang('users.status'): {{ $recipe->approved() ? trans('users.checked') : trans('users.not_checked') }}
					</p>
					<p class="project-title">
						@lang('users.date') {{ facebookTimeAgo($recipe->created_at) }}
					</p>
				</div>
			</li>
		</a>
	@empty
		<p class="content center">@lang('users.this_user_does_not_have_recipes')</p>
	@endforelse

	{{ $recipes->links() }}
</div>

@endsection