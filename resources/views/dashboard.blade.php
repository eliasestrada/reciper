@extends('layouts.app')

@section('title', Auth::user()->name)

@section('body')

<div class="wrapper">

    <h2 class="headline">{{ Auth::user()->name }}</h2>

	@if (Auth::user()->author === 1)
		<a href="/recipes/create" title="Добавить рецепт" class="button">Новый рецепт</a>
		<a href="/my_recipes" title="Мои рецепты" class="button">Мои рецепты</a>
		<a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>
		<a href="/authors" title="Авторы" class="button" {{ $notifications }}>Авторы</a>
	@endif

	@if (Auth::user()->admin === 1)
		<a href="/checklist" title="Проверочная" class="button" {{ $allunapproved }}>Проверочная</a>
	@endif

    {{--  3 Cards  --}}
    <div class="dashboard-cards">
        <div style="background: url('{{ asset('storage/other/food.jpg') }}');">
            <div class="dashboard-cards-rows">
                <i class="fa fa-file-text-o" style="font-size: 2.5em;"></i>
            </div>
            <div class="dashboard-cards-rows">
                <h3 class="headline">Рецепты</h3>
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
                <h3 class="headline">Посетители</h3>
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
                <h3 class="headline">Клики</h3>
            </div>
            <div class="dashboard-cards-rows">
                <h3>{{ $allclicks }}</h3>
            </div>
        </div>
    </div>
</div>

@endsection