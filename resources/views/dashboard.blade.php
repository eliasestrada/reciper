@extends('layouts.app')

@section('title', Auth::user()->name)

@section('body')

<div class="wrapper">

    <div class="content">
        <h2>{{ Auth::user()->name }}</h2>
    </div>

	<a href="/my_recipes" title="Мои рецепты" class="button">Мои рецепты</a>
	<a href="/recipes/create" title="Добавить рецепт" class="button">Добавить рецепт</a>
	<a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>

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
</div>

@endsection