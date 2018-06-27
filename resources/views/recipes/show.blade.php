@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
	<div class="recipe-content center-align">

		{{--  Likes  --}}
		<div class="like-for-author-section">
			<a href="/users/{{ $recipe->user->id }}" class="user-icon-on-single-recipe" style="background:url({{ asset('storage/uploads/'.$recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

			@if ($recipe->done())
				<like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}"></like>
			@endif
		</div>

		@auth {{--  Buttons  --}}
			@if (user()->hasRecipe($recipe->user_id))
				<div class="fixed-action-btn">
					<a href="#" class="btn-floating main btn-large pulse z-depth-3"><i class="large material-icons">more_vert</i></a>
					<ul>
						<li> {{--  Delete button  --}}
							<delete-recipe-btn
								recipe-id="{{ $recipe->id }}"
								deleted-fail="{{ trans('recipes.deleted_fail') }}"
								deleting="{{ trans('recipes.deleting') }}"
								confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
							</delete-recipe-btn>
						</li>
						<li> {{--  Edit button  --}}
							<a href="/recipes/{{ $recipe->id }}/edit" title="@lang('recipes.edit_recipe')" class="btn-floating green btn-large">
								<i class="large material-icons">mode_edit</i>
							</a>
						</li>
					</ul>
				</div>
			@endif
		@endauth

		@admin
			@if (!$recipe->done())
				<div class="py-2">

					{{-- Approve --}}
					<form action="{{ action('ApproveController@ok', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_publish')')">
						@csrf
						<button class="btn green" type="submit">
							<i class="material-icons">check</i>
						</button>
					</form>

					{{-- Cancel --}}
					<form action="{{ action('ApproveController@cancel', ['recipe' => $recipe->id]) }}" method="post" class="d-inline-block" onsubmit="return confirm('@lang('recipes.are_you_sure_to_cancel')')">
						@csrf
						<button class="btn red" type="submit">
							<i class="material-icons">cancel</i>
						</button>
					</form>
				</div>
			@endif
		@endadmin

		<div class="center-align">
			<h1 class="decorated">{{ $recipe->getTitle() }}</h1>
		</div>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" class="recipe-img">

		{{--  Category  --}}
		<div class="center-align py-3">
			@foreach ($recipe->categories as $category)
				<a href="/search?for={{ $category->getName() }}" title="{{ $category->getName() }}">
					<span class="new badge p-1 px-2" style="float:none;">{{ $category->getName() }}</span>
				</a>
			@endforeach
		</div>

		{{--  Time  --}}
		<div class="my-3">
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
			<p>@lang('recipes.added') {{ timeAgo($recipe->created_at) }}</p>
			<a href="/users/{{ $recipe->user->id }}" title="@lang('recipes.search_by_author')">
				<p>@lang('recipes.author'): {{ optional($recipe->user)->name }}</p>
			</a>
		</div>
	</div>

	{{-- API: Еще рецепты Sidebar --}}
	<div class="side-bar center-align">
		<h6 class="decorated pb-3">@lang('recipes.more')</h6>
		<random-recipes-sidebar resipe-id="{{ $recipe->id }}">
			@include('includes.preloader')
		</random-recipes-sidebar>
	</div>
</section>

@endsection

@section('script')
	@include('includes.js.floating-btn')
@endsection