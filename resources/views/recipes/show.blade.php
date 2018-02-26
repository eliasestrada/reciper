@extends('layouts.app')

@section('content')

<div class="wrapper">
    <section class="grid-recipe">
        <div class="recipe-content">

            <!-- Лайки -->
            <div style="font-weight:bold;">
                <i class="fa fa-heart-o like-icon"></i> 
                <i>{{ $recipe->likes }}</i>
            </div>

            @auth
                @if (Auth::user()->id == $recipe->user_id)
                    <div class="recipe-buttons">
                        {{--  Edit button  --}}
                        <a href="{{ url('/recipes/'.$recipe->id.'/edit') }}" title="Редактировать рецепт" class="fa">&#xf040;</a>

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

            <div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }}</div>

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
                <p>Добавленно {{ $recipe->date }}</p>
                <p>Автор: {{ $recipe->author }}</p>
                <p>{{ $recipe->views }} просмотров</p>
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

@endsection
