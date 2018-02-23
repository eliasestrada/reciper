@extends('layouts.app')

@section('content')
    <section class="grid-recipe">
        <div class="recipe-content">

            <!-- Лайки -->
            <div style="font-weight:bold;">
                <i class="fa fa-heart-o like-icon"></i> 
                <i>{{ $recipe->likes }}</i>
            </div>
            
            <!-- Название рецепта -->
            <h1>{{ $recipe->name }}</h1>

            <!-- Краткое описание -->
            <p>{{ $recipe->intro }}</p>

            <!-- Картинка -->
            <img src="{{ asset('img.jpg') }}" alt="{{ $recipe->name }}" title="{{ $recipe->name }}" class="recipe-img">

            <!-- Категория -->
            <a href="#" title="link">
                <span class="category">{{ $recipe->category }}</span>
            </a>

            <!-- Время приготовления -->
            <div class="date"><i class="fa fa-clock-o"></i> {{ $recipe->time }}</div>

            <!-- Ингридиенты -->
            <div class="items">
                <h3>Ингридиенты</h3>
                <ul>{{ $recipe->ingredients }}</ul>
            </div>

            <!-- Совет -->
            <p>{{ $recipe->advice }}</p>

            <!-- Название рецепта -->
            <span class="headline">{{ $recipe->name }}</span>

            <!-- Приготовление -->
            <ol class="instruction">{{ $recipe->text }}</ol>

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
                        <img src="media/img/pictures/img1.jpg" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="media/img/pictures/img2.jpg" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="media/img/pictures/img3.jpg" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
                <li>
                    <a href="recipe.php">
                        <img src="media/img/pictures/img1.jpg" alt="..">
                    </a>
                    <p>Курица и что-то еще непонятное</p>
                </li>
            </ul>
        </div>
    </section>
@endsection