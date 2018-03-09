@extends('layouts.user')

@section('title', Auth::user()->name)

@section('head')
	<style>#my-profile { border-bottom: 3px solid #a8a8a8; }</style>
@endsection

@section('content')

<div class="wrapper">
	<div class="profile-header">
		<h1>{{ Auth::user()->name }}</h1>
		<img src="{{ asset('storage/uploads/'.Auth::user()->image) }}" alt="{{ Auth::user()->name }}" />
	</div>
	
	<a href="/recipes/create" title="Добавить рецепт" class="button">Новый рецепт</a>
	<a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>

	@if (Auth::user()->admin === 1)
		<a href="/checklist" title="Проверочная" class="button" {{ $allunapproved }}>Проверочная</a>
		<a href="/feedback" title="Обратная связь" class="button" {{ $allfeedback }}>Обратная связь</a>
		<a href="/statistic" title="Статистика" class="button">Статистика</a>
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