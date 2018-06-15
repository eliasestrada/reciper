@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
	<div class="recipe-content center-align">

		{{--  Likes  --}}
		<div class="like-for-author-section">
			<a href="/users/{{ $recipe->user->id }}" class="user-icon" style="background:url({{ asset('storage/uploads/'.$recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

			<like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}"></like>
		</div>

		@auth
		{{--  Buttons  --}}
			@if (user()->hasRecipe($recipe->user_id))
				<div class="recipe-buttons">

					{{--  Edit button  --}}
					<a href="/recipes/{{ $recipe->id }}/edit" title="@lang('recipes.edit_recipe')" class="edit-recipe-icon icon-edit"></a>

					{{--  Delete button  --}}
					<delete-recipe-btn
						recipe-id="{{ $recipe->id }}"
						deleted-fail="{{ trans('recipes.deleted_fail') }}"
						deleting="{{ trans('recipes.deleting') }}"
						confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
					</delete-recipe-btn>
				</div>
			@endif
		@endauth

		@admin
			@if (!$recipe->approved() && $recipe->ready())
				<div class="recipe-buttons">

					{{-- Approve --}}
					<form action="{{ action('ApproveController@ok', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" style="width:auto" onsubmit="return confirm('@lang('recipes.are_you_sure_to_publish')')">
						@csrf
						<input type="submit" value="" class="edit-recipe-icon icon-approve">
					</form>

					{{-- Cancel --}}
					<form action="{{ action('ApproveController@cancel', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" style="width:auto" onsubmit="return confirm('@lang('recipes.are_you_sure_to_cancel')')">
						@csrf
						<input type="submit" value="" class="edit-recipe-icon icon-cancel">
					</form>
				</div>
			@endif
		@endadmin

		<div class="center-align">
			<h1 class="headline">{{ $recipe->getTitle() }}</h1>
		</div>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" class="recipe-img">

		{{--  Category  --}}
		@foreach ($recipe->categories as $category)
			<a href="/search?for={{ $category->getName() }}" title="{{ $category->getName() }}">
				<span class="category">{{ $category->getName() }}</span>
			</a>
		@endforeach

		{{--  Time  --}}
		<div class="date my-3">
			<i class="material-icons">timer</i>
			{{ $recipe->time }} @lang('recipes.min').
		</div>

		{{--  Intro  --}}
		<blockquote class="left-align">
			{{ $recipe->getIntro() }}
		</blockquote>

		<hr />

		{{--  Items --}}
		<blockquote class="items">
			<h5 class="decorated">@lang('recipes.ingredients')</h5>
			{!! $recipe->ingredientsWithListItems() !!}
		</blockquote>

		<hr />

		{{--  Приготовление  --}}
		<blockquote style="border:none;">
			<h5 class="decorated py-3">@lang('recipes.text_of_recipe')</h5>
			<ol class="instruction unstyled-list">
				{!! $recipe->textWithListItems() !!}
			</ol>
		</blockquote>
		
		<hr />
		<h5 class="decorated pt-3">@lang('recipes.bon_appetit')!</h5>

		{{--  Дата --}}
		<div class="date mt-4">
			<p>@lang('recipes.added') {{ facebookTimeAgo($recipe->created_at) }}</p>
			<a href="/users/{{ $recipe->user->id }}" title="@lang('recipes.search_by_author')">
				<p>@lang('recipes.author'): {{ optional($recipe->user)->name }}</p>
			</a>
		</div>
	</div>

	{{-- API: Еще рецепты Sidebar --}}
	<div class="side-bar center-align">
		<h6 class="decorated pb-3">@lang('recipes.more')</h6>
		<random-recipes-sidebar resipe-id="{{ $recipe->id }}"></random-recipes-sidebar>
	</div>
</section>

@endsection