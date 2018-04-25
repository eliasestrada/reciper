@extends('layouts.app')

@section('title', $recipe->title)

@section('content')

<section class="grid-recipe">
	<div class="recipe-content">

		{{--  Likes  --}}
		<div id="favorite-buttons" style="font-weight:bold;">
			@if (Cookie::get('liked') == null)
				<a href="/recipes/{{ $recipe->id }}/like" class="like-icon like-icon-empty" title="@lang('recipes.like')"></a>
			@else
				<a href="/recipes/{{ $recipe->id }}/dislike" class="like-icon like-icon-full" title="@lang('recipes.dislike')"></a>
			@endif
			<i>{{ $recipe->likes }}</i>
		</div>

		@auth
		{{--  Buttons  --}}
			@if (user()->hasRecipe($recipe->user_id) && !$recipe->ready())
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
		@endauth

		{{--  Buttons for admin  --}}
		@admin
			@if (!$recipe->approved() && $recipe->ready())
				<div class="recipe-buttons">
					{!! Form::open(['action' => ['ApproveController@ok', $recipe->id], 'method' => 'post', 'style' => 'width: auto; display: inline-block;', 'onsubmit' => 'return confirm("Вы точно хотите опубликовать этот рецепт?")']) !!}
						{{ Form::submit('', ['class' => 'edit-recipe-icon icon-approve']) }}
					{!! Form::close() !!}

					{!! Form::open(['action' => ['ApproveController@cancel', $recipe->id], 'method' => 'post', 'style' => 'width: auto; display: inline-block;', 'onsubmit' => 'return confirm("Вы точно хотите вернуть этот рецепт автору на доработку?")']) !!}
						{{ Form::submit('', ['class' => 'edit-recipe-icon icon-cancel']) }}
					{!! Form::close() !!}
				</div>
			@endif
		@endadmin
		
		<h1 class="headline">{{ title_case($recipe->title) }}</h1>

		<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->name }}" class="recipe-img">
		
		{{--  Intro  --}}
		<p>{{ $recipe->intro }}</p>

		{{--  Category  --}}
		<a href="/search?for={{ $recipe->category }}" title="{{ $recipe->category }}">
			<span class="category">{{ $recipe->category }}</span>
		</a>

		{{--  Time  --}}
		<div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }} мин.</div>

		{{--  Items --}}
		<h3 class="decorated"><span>@lang('recipes.ingredients')</span></h3>
		<div class="items" id="items">
			<ul>{!! $recipe->ingredientsWithListItems() !!}</ul>
			<button class="add-to-list-btn" id="add-to-list-btn">Добавить в список</button>
		</div>

		{{--  Совет  --}}
		<p>{{ $recipe->advice }}</p>

		{{--  Приготовление  --}}
		<h3 class="decorated"><span>@lang('recipes.text_of_recipe')</span></h3>
		<ol class="instruction unstyled-list">
			{!! $recipe->textWithListItems() !!}
		</ol>

		<h3 class="decorated"><span>@lang('recipes.bon_appetit')!</span></h3>

		{{--  Дата и Автор  --}}
		<div class="date">
			<p>@lang('recipes.added') {{ facebookTimeAgo($recipe->created_at) }}</p>
			<p>@lang('recipes.author'): {{ $recipe->author }}</p>
		</div>
	</div>

	{{-- API: Еще рецепты Sidebar --}}
	<div class="side-bar">
		<h3 class="decorated"><span>@lang('recipes.more')</span></h3>
		<ul class="unstyled-list target-for-random-recipes"></ul>
	</div>
</section>

@endsection

@section('script')
<script defer>
	// Like Icon
	let likeIcon = document.querySelector(".like-icon")
	let targetForRandomRecipes = document.querySelector(".target-for-random-recipes")

	likeIcon.addEventListener('click', animateLikeButton)

	function animateLikeButton() {
		likeIcon.classList.add("disappear")
		likeIcon.style.opacity = '0'
	}

	// This function fetches recipes
	(function fetchData() {
		fetch('/api/show-random-recipes/{{ $recipe->id }}')
		.then(res => res.json())
		.then(res => {
			let output = ''
			let i = 0;
			res.data.forEach(random => {
				i += 2
				output += `
					<li class="side-bar-recipe" style="animation: appearWithRotate 1.${ i }s;">
						<a href="/recipes/${ random.id }" title="${ random.title }">
							<img src="{{ asset('storage/images/${ random.image }') }}" alt="${ random.title }" id="target-img">
						</a>
						<div class="side-bar-content">
							<h3>${ random.title }</h3>
						</div>
					</li>`
			})
			targetForRandomRecipes.innerHTML = output
		})
		.catch(err => console.log(err))
	})()

	// List Items
	let i = 0
	let items = []
	let list = document.getElementById('list-of-added-items')

	document.querySelectorAll('#items li').forEach(item => {
		i++
		items.push(`<li class="each-item">${ item.innerHTML }</li>`)
	})

	list.innerHTML = items.join('')

	document.querySelectorAll('.each-item').forEach(item => {
		item.addEventListener('click', () => {
			if (item.className == "each-item checked") {
				item.classList.remove('checked')
			} else {
				item.classList.add("checked")
			}
			
		})
	})

</script>
@endsection