@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h2>Рецепты</h2>
    <section class="recipes">

        @if (count($recipes) > 0)
            @foreach ($recipes as $recipe)
                <div>
                    <!-- Image -->
                    <a href="{{ url('/recipes/'.$recipe->id) }}">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" title="{{$recipe->title}}">
                    </a>
                    <div class="cards-content">
                        <!-- Title -->
                        <h3>{{$recipe->title}}</h3>
                        <!-- Intro -->
                        <p>{{ mb_substr($recipe->intro, 0, 180, "utf-8") }}</p>
                        <!-- Category -->
                        <a href="#" title="link"><span class="category">{{$recipe->category}}</span></a>
                        <!-- Time -->
                        <div class="date"><i class="fa fa-clock-o"></i> {{$recipe->time}} мин.</div>
                    </div>
                </div>
            @endforeach

            {{ $recipes->links() }}

        @else
            <p class="content">Нет рецептов</p>
        @endif
    </section>

    <!-- Add recipe button-->
    @auth
        <a href="{{ url('/recipes/create') }}" class="fa fa-plus-circle add-material" title="Добавить рецепт"></a>
    @endauth
</div>

@endsection