@extends('layouts.app')

@section('title', Auth::user()->name)

@section('body')

<div class="wrapper">

    <div class="content">
        <h2>{{ Auth::user()->name }}</h2>
    </div>

    <a href="/recipes/create" title="Добавить рецепт" class="button">Добавить рецепт</a>
    <a href="/notifications" title="Оповещения" class="button" {{ $notifications }}>Оповещения</a>

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

    {{--  Unapproved recipes  --}}
    @if (Auth::user()->admin === 1)
        <div class="list-of-recipes">
            @if (count($unapproved) > 0)
                <h3>Рецепты на рассмотрении {{ $allunapproved }}</h3>
                @foreach ($unapproved as $unapprove)
                    <div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($unapprove->updated_at) }}" data-author="Автор: {{ $unapprove->author }}">
                        <a href="/recipes/{{ $unapprove->id }}">
                            <img src="{{ asset('storage/images/'.$unapprove->image) }}" alt="{{ $unapprove->title }}" title="Перейти к рецепту">
                        </a>
                        <div class="each-content">
                            <span>{{ $unapprove->title }}</span>
                            <span>{{ $unapprove->intro }}</span>
                        </div>
                    </div>
                @endforeach
                {{ $unapproved->links() }}
			@else
				<div class="content">
					<h4>Нет непровереных рецептов</h4>
				</div>
            @endif
        </div>
    @endif

    {{--  All my recipes  --}}
    @if (Auth::user()->author === 1)
        <div class="list-of-recipes">
            @if (count($recipes) > 0)
                <h3>Мои рецепты</h3>
                @foreach ($recipes as $recipe)
            <div class="each-recipe" data-updated="Дата написания {{ facebookTimeAgo($recipe->updated_at) }}" data-author="Статус: {{ $recipe->approved === 1 ? 'Проверен' : 'Не проверен' }}">
                        <a href="/recipes/{{ $recipe->id }}">
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="Перейти к рецепту">
                        </a>
                        <div class="each-content">
                            <span>{{ $recipe->title }}</span>
                            <span>{{ $recipe->intro }}</span>
                        </div>
                    </div>
                @endforeach
                {{ $recipes->links() }}
			@else
				<div class="content">
					<h4>У вас пока нет рецептов</h4>
				</div>
            @endif
        </div>
    @endif
</div>

@endsection