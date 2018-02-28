@extends('layouts.app')

@section('content')

<div class="wrapper">
    <div class="content">
        <h2>{{ Auth::user()->name }}</h2>
    </div>

    <a href="/recipes/create" title="Добавить рецепт" class="button">Добавить рецепт</a>

    <div class="dashboard-cards">
        <div style="background: url('{{ asset('storage/other/food.jpg') }}');">
            <div class="dashboard-cards-rows">
                <i class="fa fa-file-text-o" style="font-size: 2.5em;"></i>
            </div>
            <div class="dashboard-cards-rows">
                <h3>Рецепты</h3>
            </div>
            <div class="dashboard-cards-rows">
                <h3>{{ $allrecipes }}</h3>
            </div>
        </div>
        <div style="background: url('{{ asset('storage/other/people.jpg') }}');">
            <div class="dashboard-cards-rows">
                <i class="fa fa-users" style="font-size: 2.5em;"></i>
            </div>
            <div class="dashboard-cards-rows">
                <h3>Посетители</h3>
            </div>
            <div class="dashboard-cards-rows">
                <h3>{{ $allvisits }}</h3>
            </div>
        </div>
        <div style="background: url('{{ asset('storage/other/click.jpg') }}');">
            <div class="dashboard-cards-rows">
                <i class="fa fa-mouse-pointer" style="font-size: 2.5em;"></i>
            </div>
            <div class="dashboard-cards-rows">
                <h3>Клики</h3>
            </div>
            <div class="dashboard-cards-rows">
                <h3>{{ $allclicks }}</h3>
            </div>
        </div>
    </div>

    @if (Auth::user()->admin === 1)
        <div class="list-of-recipes">
            <h3>Рецепты на рассмотрении</h3>

            @if (count($recipes) > 0)
                @foreach ($recipes as $recipe)
                    <a href="#">
                        <div class="each-recipe">
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="{{ $recipe->title }}">
                            <div class="each-content">
                                <span>{{ $recipe->title }}</span>
                                <span>{{ mb_substr($recipe->intro, 0, 150, "utf-8") }}{{ strlen($recipe->intro) > 150 ? '...' : '' }}</span>
                                <p>{{ $recipe->author }}</p>
                                <p>{{ $recipe->updated_at }}</p>
                            </div>
                            
                        </div>
                    </a>
                @endforeach
            @else
                <p class="content">Нет непровереных рецептов.</p>
            @endif
        </div>
    @endif
</div>

@endsection