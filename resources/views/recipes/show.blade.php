@extends('layouts.app')

@section('content')

<div class="wrapper">
    <section class="grid-recipe">
        <div class="recipe-content">

            <!-- Лайки -->
            <div id="favorite-buttons" style="font-weight:bold;">
                @if (Cookie::get('liked') == null)
                    {!! Form::open(['action' => ['RecipesController@like', $recipe->id], 'method' => 'post', 'style' => 'width: auto;']) !!}
                        {{ Form::hidden('todo', 'set') }}
                        {{ Form::submit('&#xf08a;', ['class' => 'like-icon fa']) }}
                        <i>{{ $recipe->likes }}</i>
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['action' => ['RecipesController@like', $recipe->id], 'method' => 'post', 'style' => 'width: auto;']) !!}
                        {{ Form::hidden('todo', 'delete') }}
                        {{ Form::submit('&#xf004;', ['class' => 'like-icon fa']) }}
                        <i>{{ $recipe->likes }}</i>
                    {!! Form::close() !!}
                @endif
            </div>

            @auth
                @if (Auth::user()->id == $recipe->user_id && $recipe->ready == 0)
                    <div class="recipe-buttons">
                        {{--  Edit button  --}}
                        <a href="/recipes/{{ $recipe->id }}/edit" title="Редактировать рецепт" class="fa">&#xf040;</a>

                        {{--  Delete button  --}}
                        {!! Form::open(['action' => ['RecipesController@destroy', $recipe->id], 'method' => 'post', 'style' => 'width: auto;']) !!}
                            {{ Form::hidden('_method', 'DELETE') }}
                            {{ Form::submit('&#xf014;', ['class' => 'fa', 'style' => 'background: brown;']) }}
                        {!! Form::close() !!}
                    </div>
                @endif
            @endauth
            
            <h1>{{ $recipe->title }}</h1>

            <p>{{ $recipe->intro }}</p>

            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->name }}" title="{{ $recipe->name }}" class="recipe-img">

            <a href="#" title="link">
                <span class="category">{{ $recipe->category }}</span>
            </a>

            <div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }} мин.</div>

            <div class="items">
                <h3>Ингридиенты</h3>
                <ul>{!! convertToListItems($recipe->ingredients) !!}</ul>
            </div>

            <!-- Совет -->
            <p>{{ $recipe->advice }}</p>

            <!-- Название рецепта -->
            <span class="headline">{{ $recipe->name }}</span>

            <!-- Приготовление -->
            <ol class="instruction">{!! convertToListItems($recipe->text) !!}</ol>

            <!-- Дата и Автор -->
            <div class="date">
                <p>Добавленно {{ facebookTimeAgo($recipe->updated_at) }}</p>
                <p>Автор: {{ $recipe->author }}</p>
            </div>
        </div>

        <!-- Еще рецепты -->
        <div class="side-bar">
            <span class="headline">Еще рецепты:</span>
            <ul>
                <li>
                    <a href="recipe.php">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
            </ul>
        </div>
    </section>
</div>

<script>
    let likeIcon = document.querySelector(".like-icon")

    likeIcon.addEventListener('click', animateLikeButton)

    function animateLikeButton() {
        likeIcon.classList.add("disappear")
        likeIcon.style.opacity = '0'
    }
</script>

@endsection