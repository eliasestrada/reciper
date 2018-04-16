@extends('layouts.app')

@section('title', $recipe->title)

@section('content')

<section class="grid-recipe">
	<div class="recipe-content">

		{{--  Likes  --}}
		<div id="favorite-buttons" style="font-weight:bold;">
			@if (Cookie::get('liked') == null)
				<a href="/recipes/{{ $recipe->id }}/like" class="like-icon like-icon-empty"></a>
			@else
				<a href="/recipes/{{ $recipe->id }}/dislike" class="like-icon like-icon-full"></a>
			@endif
			<i>{{ $recipe->likes }}</i>
		</div>

		{{--  Buttons  --}}
		@auth
			@if (Auth::user()->id == $recipe->user_id && $recipe->ready === 0)
				<div class="recipe-buttons">
					{{--  Edit button  --}}
					<a href="/recipes/{{ $recipe->id }}/edit" title="Редактировать рецепт" class="edit-recipe-icon icon-edit"></a>

					{{--  Delete button  --}}
					{!! Form::open(['action' => ['RecipesController@destroy', $recipe->id], 'method' => 'post', 'style' => 'width: auto; display: inline-block;', 'onsubmit' => 'return confirm("Вы точно хотите удалить этот рецепт?")']) !!}
						{{ method_field('delete') }}
						{{ Form::submit('', ['class' => 'edit-recipe-icon icon-delete']) }}
					{!! Form::close() !!}
				</div>
			@endif

			{{--  Buttons for admin  --}}
			@if (Auth::user()->admin === 1 && $recipe->approved === 0 && $recipe->ready === 1)
				<div class="recipe-buttons">
					{!! Form::open(['action' => ['RecipesController@answer', $recipe->id], 'method' => 'post', 'style' => 'width: auto; display: inline-block;', 'onsubmit' => 'return confirm("Вы точно хотите опубликовать этот рецепт?")']) !!}
						{{ Form::hidden('answer', 'approve') }}
						{{ Form::submit('', ['class' => 'edit-recipe-icon icon-approve']) }}
					{!! Form::close() !!}

					{!! Form::open(['action' => ['RecipesController@answer', $recipe->id], 'method' => 'post', 'style' => 'width: auto; display: inline-block;', 'onsubmit' => 'return confirm("Вы точно хотите вернуть этот рецепт автору на доработку?")']) !!}
						{{ Form::hidden('answer', 'cancel') }}
						{{ Form::submit('', ['class' => 'edit-recipe-icon icon-cancel']) }}
					{!! Form::close() !!}
				</div>
			@endif
		@endauth
		
		<h1 class="headline">{{ $recipe->title }}</h1>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->name }}" class="recipe-img">
		
		{{--  Intro  --}}
		<p>{{ $recipe->intro }}</p>

		{{--  Category  --}}
		<a href="/search?for={{ $recipe->category }}" title="{{ $recipe->category }}">
			<span class="category">{{ $recipe->category }}</span>
		</a>

		{{--  Time  --}}
		<div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }} мин.</div>

		{{--  Items ( Ингридиенты ) --}}
		<h3 class="decorated"><span>Ингридиенты</span></h3>
		<div class="items">
			<ul>{!! $recipe->presentIngredients() !!}</ul>
		</div>

		{{--  Совет  --}}
		<p>{{ $recipe->advice }}</p>

		{{--  Приготовление  --}}
		<h3 class="decorated"><span>Приготовление</span></h3>
		<ol class="instruction unstyled-list">
			{!! $recipe->presentText() !!}
		</ol>

		<h3 class="decorated"><span>Приятного аппетита!</span></h3>

		{{--  Дата и Автор  --}}
		<div class="date">
			<p>Добавленно {{ facebookTimeAgo($recipe->created_at) }}</p>
			<p>Автор рецепта: {{ $recipe->author }}</p>
		</div>
	</div>

	{{--  Еще рецепты Sidebar --}}
	<div class="side-bar">
		<h3 class="decorated"><span>Еще рецепты:</span></h3>
		@if (count($random_recipes) > 0)
			<ul class="unstyled-list">
				@foreach ($random_recipes as $random)
					<li class="side-bar-recipe">
						<a href="/recipes/{{ $random->id }}" title="{{ $random->title }}">
							<!-- Image -->
							<img src="{{ asset('storage/images/'.$random->image) }}" alt="{{ $random->title }}">
						</a>
						<div class="side-bar-content">
							<!-- Title -->
							<h3>{{ $random->title }}</h3>
						</div>
					</li>
				@endforeach
			</ul>
		@endif
	</div>
</section>

@endsection

@section('script')
<script defer>
	let likeIcon = document.querySelector(".like-icon")

	likeIcon.addEventListener('click', animateLikeButton)

	function animateLikeButton() {
		likeIcon.classList.add("disappear")
		likeIcon.style.opacity = '0'
	}
</script>
@endsection