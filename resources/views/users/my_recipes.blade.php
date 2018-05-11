@extends('layouts.app')

@section('title', trans('users.my_recipes'))

@section('content')

<h2 class="headline">@lang('users.my_recipes') {{ $recipes->count() }}</h2>

{{--  All my recipes  --}}
@author
	<div class="item-list unstyled-list">
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
			<p class="content center">@lang('users.no_recipes_yet')</p>
		@endforelse

		{{ $recipes->links() }}
	</div>
@endauthor

@endsection