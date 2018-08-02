@extends('layouts.app')

@section('title', $recipe->getTitle())

@section('content')

<section class="grid-recipe pt-3">
	<div class="recipe-content center">

		{{--  Likes  --}}
		<div class="like-for-author-section">
			<a href="/users/{{ $recipe->user->id }}" class="user-icon-on-single-recipe" style="background:url({{ asset('storage/users/' . $recipe->user->image) }})" title="@lang('recipes.search_by_author')"></a>

			@if ($recipe->done())
				<like likes="{{ count($recipe->likes) }}" recipe-id="{{ $recipe->id }}">
					<div class="btn-wrapper">
						<a class="btn-like">
							<svg class="btn__icon" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
								<path class="btn__fill" d="M364,48.057c-39.7,0.111-78.035,14.502-108,40.544c-29.965-26.042-68.3-40.433-108-40.544  C69.434,44.931,3.21,106.087,0.084,184.653c-0.038,0.943-0.066,1.886-0.084,2.829c0,114.912,222.144,258.176,247.456,274.112  c5.188,3.243,11.772,3.243,16.96,0C356.352,404.921,512,283.353,512,187.481c-1.564-78.612-66.559-141.072-145.171-139.508  C365.886,47.992,364.943,48.02,364,48.057z"/>
								<path class="btn__border" d="M256,464.057c-3.025,0.015-5.991-0.84-8.544-2.464C222.144,445.657,0,302.393,0,187.481  C1.564,108.869,66.559,46.409,145.171,47.973c0.943,0.019,1.886,0.047,2.829,0.084c39.699,0.116,78.032,14.507,108,40.544  c29.968-26.037,68.301-40.428,108-40.544c78.566-3.126,144.79,58.03,147.916,136.595c0.038,0.943,0.066,1.886,0.084,2.829  c0,96-155.616,217.44-247.584,274.208C261.885,463.245,258.971,464.065,256,464.057z M148,80.057  C86.885,77.15,34.985,124.338,32.078,185.453c-0.032,0.676-0.058,1.352-0.078,2.028c0,67.2,114.56,171.136,224,241.664  c112.64-71.2,224-175.296,224-241.664c-1.787-61.158-52.813-109.288-113.972-107.502c-0.676,0.02-1.352,0.046-2.028,0.078  c-36.428-0.035-71.243,15.026-96.16,41.6c-6.432,6.539-16.947,6.626-23.486,0.194c-0.065-0.064-0.13-0.128-0.194-0.194  C219.243,95.084,184.428,80.022,148,80.057z"/>
							</svg>
						</a>
					</div>
				</like>
			@endif
		</div>

		@auth {{--  Buttons  --}}
			@if (user()->hasRecipe($recipe->user_id))
				<div class="fixed-action-btn">
					<a href="#" class="btn-floating main btn-large pulse z-depth-3" id="_more">
						<i class="large material-icons">more_vert</i> 
					</a>
					<ul>
						<li> {{--  Delete button  --}}
							<delete-recipe-btn
								recipe-id="{{ $recipe->id }}"
								deleted-fail="{{ trans('recipes.deleted_fail') }}"
								delete-recipe-tip="{{ trans('tips.delete_recipe') }}"
								confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
							</delete-recipe-btn>
						</li>
						<li> {{--  Edit button  --}}
							<a href="/recipes/{{ $recipe->id }}/edit" class="btn-floating btn-large green d-flex tooltipped" data-tooltip="@lang('tips.edit_recipe')" data-position="left" id="_edit">
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

		<div class="center">
			<h1 class="decorated">{{ $recipe->getTitle() }}</h1>
		</div>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->getTitle() }}" class="recipe-img">

		{{--  Category  --}}
		<div class="center py-3">
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
			<ol>{!! $recipe->ingredientsWithListItems() !!}</ol>
		</blockquote>

		<hr />

		{{--  Text  --}}
		<blockquote style="border:none;">
			<h5 class="decorated py-3">@lang('recipes.text_of_recipe')</h5>
			<ol class="instruction unstyled-list">{!! $recipe->textWithListItems() !!}</ol>
		</blockquote>
		
		<hr />
		<h5 class="decorated pt-3">@lang('recipes.bon_appetit')!</h5>

		{{--  Date --}}
		<div class="date mt-4">
			<p>@lang('recipes.added') {{ timeAgo($recipe->created_at) }}</p>
			<a href="/users/{{ $recipe->user->id }}" title="@lang('recipes.search_by_author')">
				<p>@lang('recipes.author'): {{ optional($recipe->user)->name }}</p>
			</a>
		</div>
	</div>

	{{-- API: Еще рецепты Sidebar --}}
	<div class="side-bar center">
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