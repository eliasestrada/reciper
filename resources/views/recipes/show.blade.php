@extends('layouts.app')

@section('title', $recipe->title)

@section('content')

<div class="wrapper">
    <section class="grid-recipe">
        <div class="recipe-content">

            {{--  Likes  --}}
            <div id="favorite-buttons" style="font-weight:bold;">
				@if (Cookie::get('liked') == null)
					<a href="#" id="like-btn">
						<svg viewBox="0 0 51.997 51.997" width="25px" style="fill:brown;" class="like-icon">
							<path d="M51.911,16.242C51.152,7.888,45.239,1.827,37.839,1.827c-4.93,0-9.444,2.653-11.984,6.905 c-2.517-4.307-6.846-6.906-11.697-6.906c-7.399,0-13.313,6.061-14.071,14.415c-0.06,0.369-0.306,2.311,0.442,5.478 c1.078,4.568,3.568,8.723,7.199,12.013l18.115,16.439l18.426-16.438c3.631-3.291,6.121-7.445,7.199-12.014
							C52.216,18.553,51.97,16.611,51.911,16.242z M49.521,21.261c-0.984,4.172-3.265,7.973-6.59,10.985L25.855,47.481L9.072,32.25
							c-3.331-3.018-5.611-6.818-6.596-10.99c-0.708-2.997-0.417-4.69-0.416-4.701l0.015-0.101C2.725,9.139,7.806,3.826,14.158,3.826
							c4.687,0,8.813,2.88,10.771,7.515l0.921,2.183l0.921-2.183c1.927-4.564,6.271-7.514,11.069-7.514 c6.351,0,11.433,5.313,12.096,12.727C49.938,16.57,50.229,18.264,49.521,21.261z" />
						</svg>
					</a>
					<i>{{ $recipe->likes }}</i>
				@else
					<a href="/recipes/{{ $recipe->id }}/dislike" id="dislike-btn">
						<svg viewBox="0 0 50 50" width="25px" style="fill:brown;" class="like-icon">
							<path d="M24.85,10.126c2.018-4.783,6.628-8.125,11.99-8.125c7.223,0,12.425,6.179,13.079,13.543 c0,0,0.353,1.828-0.424,5.119c-1.058,4.482-3.545,8.464-6.898,11.503L24.85,48L7.402,32.165c-3.353-3.038-5.84-7.021-6.898-11.503
							c-0.777-3.291-0.424-5.119-0.424-5.119C0.734,8.179,5.936,2,13.159,2C18.522,2,22.832,5.343,24.85,10.126z"/>
						</svg>
					</a>
					<i>{{ $recipe->likes }}</i>
                @endif
            </div>

            {{--  Buttons  --}}
            @auth
                @if (Auth::user()->id == $recipe->user_id && $recipe->ready === 0)
                    <div class="recipe-buttons">
                        {{--  Edit button  --}}
                        <a href="/recipes/{{ $recipe->id }}/edit" title="Редактировать рецепт" class="fa">&#xf040;</a>

                        {{--  Delete button  --}}
                        {!! Form::open(['action' => ['RecipesController@destroy', $recipe->id], 'method' => 'post', 'style' => 'width: auto;', 'onsubmit' => 'return confirm("Вы точно хотите удалить этот рецепт?")']) !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('&#xf014;', ['class' => 'fa', 'style' => 'background: brown;']) }}
                        {!! Form::close() !!}
                    </div>
                @endif

                {{--  Buttons for admin  --}}
                @if (Auth::user()->admin === 1 && $recipe->approved === 0 && $recipe->ready === 1)
                    <div class="recipe-buttons">
                        {!! Form::open(['action' => ['RecipesController@answer', $recipe->id], 'method' => 'post', 'style' => 'width: auto;', 'onsubmit' => 'return confirm("Вы точно хотите опубликовать этот рецепт?")']) !!}
                            {{ Form::hidden('answer', 'approve') }}
                            {{ Form::submit('&#xf00c;', ['class' => 'fa', 'style' => 'background: green;']) }}
                        {!! Form::close() !!}

                        {!! Form::open(['action' => ['RecipesController@answer', $recipe->id], 'method' => 'post', 'style' => 'width: auto;', 'onsubmit' => 'return confirm("Вы точно хотите вернуть этот рецепт автору на доработку?")']) !!}
                            {{ Form::hidden('answer', 'cancel') }}
                            {{ Form::submit('&#xf00d;', ['class' => 'fa', 'style' => 'background: brown;']) }}
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
                <ul>{!! convertToListItems($recipe->ingredients) !!}</ul>
            </div>

            {{--  Совет  --}}
            <p>{{ $recipe->advice }}</p>

			{{--  Приготовление  --}}
			<h3 class="decorated"><span>Приготовление</span></h3>
            <ol class="instruction unstyled-list">
				{!! convertToListItems($recipe->text) !!}
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
</div>

@endsection

@section('script')
<script>
    let likeIcon = document.querySelector(".like-icon")

    likeIcon.addEventListener('click', animateLikeButton)

    function animateLikeButton() {
        likeIcon.classList.add("disappear")
        likeIcon.style.opacity = '0'
    }

	// AJAX CALL for like button
	id('like-btn').addEventListener('click', () => {
		fetch('/recipes/{{ $recipe->id }}/like')
		.then((data) => console.log(data))
		.catch((error) => console.log(error))
	})
</script>
@endsection