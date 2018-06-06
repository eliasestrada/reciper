@extends('layouts.app')

@section('title', $title)

@section('content')

<section class="grid-recipe">
	<div class="recipe-content">

		{{--  Likes  --}}
		<div id="favorite-buttons" style="font-weight:bold;">
			@if (Cookie::get('liked') != $recipe->id)
				<a href="/recipes/{{ $recipe->id }}/like" class="like-icon like-icon-empty" title="@lang('recipes.like')"></a>
			@else
				<a href="/recipes/{{ $recipe->id }}/dislike" class="like-icon like-icon-full" title="@lang('recipes.dislike')"></a>
			@endif
			<i>{{ $recipe->likes }}</i>
		</div>

		@auth
		{{--  Buttons  --}}
			@if (user()->hasRecipe($recipe->user_id))
				<div class="recipe-buttons">

					{{--  Edit button  --}}
					<a href="/recipes/{{ $recipe->id }}/edit" title="@lang('recipes.edit_recipe')" class="edit-recipe-icon icon-edit"></a>

					{{--  Delete button  --}}
					<form action="{{ action('RecipesController@destroy', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" style="width: auto" onsubmit="return confirm('@lang('recipes.are_you_sure_to_delete')')">

						@method('delete')
						@csrf

						<input type="submit" value="" class="edit-recipe-icon icon-delete">
					</form>
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

		<h1 class="headline">{{ title_case($title) }}</h1>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $title }}" class="recipe-img">
		
		{{--  Intro  --}}
		<p>{{ $intro }}</p>

		{{--  Category  --}}
		<a href="/search?for={{ $recipe->category_id }}" title="{{ $category }}">
			<span class="category">{{ $category }}</span>
		</a>

		{{--  Time  --}}
		<div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }} мин.</div>

		{{--  Items --}}
		<h3 class="decorated"><span>@lang('recipes.ingredients')</span></h3>
		<div class="items" id="items">
			<ul>{!! $recipe->ingredientsWithListItems() !!}</ul>
		</div>

		{{--  Приготовление  --}}
		<h3 class="decorated"><span>@lang('recipes.text_of_recipe')</span></h3>
		<ol class="instruction unstyled-list">
			{!! $recipe->textWithListItems() !!}
		</ol>

		<h3 class="decorated"><span>@lang('recipes.bon_appetit')!</span></h3>

		{{--  Дата и Автор  --}}
		<div class="date">
			<p>@lang('recipes.added') {{ facebookTimeAgo($recipe->created_at) }}</p>
			<p>@lang('recipes.author'): {{ optional($recipe->user)->name }}</p>
		</div>
	</div>

	{{-- API: Еще рецепты Sidebar --}}
	<div class="side-bar">
		<h3 class="decorated"><span>@lang('recipes.more')</span></h3>
		<random-recipes-sidebar resipe-id="{{ $recipe->id }}"></random-recipes-sidebar>
	</div>
</section>

@endsection

@section('script')
<script defer>
	document.querySelector(".like-icon").addEventListener('click', animateLikeButton)

	function animateLikeButton() {
		likeIcon.classList.add("disappear")
		likeIcon.style.opacity = '0'
	}
</script>
@endsection