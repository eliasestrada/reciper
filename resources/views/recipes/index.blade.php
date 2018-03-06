@extends('layouts.app')

@section('title', 'Рецепты')

@section('body')

<div class="wrapper">
    <h2 class="headline">Рецепты</h2>
    <section class="recipes">

        @if (count($recipes) > 0)
            @foreach ($recipes as $recipe)
                <div>
                    <!-- Image -->
                    <a href="/recipes/{{ $recipe->id }}">
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" title="{{$recipe->title}}">
                    </a>
                    <div class="recipes-content">
                        <!-- Title -->
                        <h3>{{$recipe->title}}</h3>
                        <!-- Intro -->
                        <p class="content">{{ mb_substr($recipe->intro, 0, 180, "utf-8") }}{{ strlen($recipe->intro) > 180 ? '...' : '' }}</p>
                        <!-- Category -->
                        <a href="/search?for={{$recipe->category}}" title="link"><span class="category">{{$recipe->category}}</span></a>
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
</div>

@endsection
