@extends('layouts.app')

@section('title', trans('users.my_recipes'))

@section('content')

<h2 class="headline">@lang('users.my_recipes') {{ $recipes->count() }}</h2>

{{--  All my recipes  --}}
@author
	<div class="list-of-recipes">
		@forelse ($recipes as $recipe)
			<div class="each-recipe" data-updated="@lang('users.date') {{ facebookTimeAgo($recipe->created_at) }}" data-author="@lang('users.status'): {{ $recipe->approved === 1 ? trans('users.checked') : trans('users.not_checked') }}" style="animation: appear 1.{{ $loop->index }}s;">

				<a href="/recipes/{{ $recipe->id }}">
					<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="@lang('users.go_to_recipe')">
				</a>

				<div class="each-content">
					<span style="font-size: 1.05em;">{{ $recipe->title }}</span>
					<br />
					<span style="color: gray;">{{ $recipe->intro }}</span>
				</div>
			</div>
		@empty
			<p class="content center">@lang('users.no_recipes_yet')</p>
		@endforelse

		{{ $recipes->links() }}
	</div>
@endauthor

@endsection