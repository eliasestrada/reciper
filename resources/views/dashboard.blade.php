@extends('layouts.app')

@section('content')

<div class="wrapper">

    {{--  Admin notification  --}}
    @if ($allunapproved > 0 && Auth::user()->notif === 1)
        <div class="notification">
            <i class="fa fa-bell-o bell-alert" style="font-size: 1.3em; margin: .5em; padding-top: .15em;"></i>
            <p>У вас есть {{ $allunapproved }} {{ $allunapproved == 1 ? 'непроверенный рецепт' : 'непроверенных рецепта' }}</p>
            {!! Form::open(['action' => ['DashboardController@closeNotification'], 'method' => 'post', 'style' => 'width: auto; display: flex;']) !!}
                {{ Form::submit('&#xf00d;', ['class' => 'fa close-notif']) }}
            {!! Form::close() !!}
        </div>
    @endif

    <div class="content">
        <h2>{{ Auth::user()->name }}</h2>
    </div>

    <a href="/recipes/create" title="Добавить рецепт" class="button">Добавить рецепт</a>

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

    @if (Auth::user()->admin === 1)
        <div class="list-of-recipes">
            @if (count($unapproved) > 0)
                <h3>Рецепты на рассмотрении {{ $allunapproved }}</h3>
                @foreach ($unapproved as $recipe)
                    <div class="each-recipe" data-updated="Обновленно {{ facebookTimeAgo($recipe->updated_at) }}" data-author="Автор: {{ $recipe->author }}">
                        <a href="/recipes/{{ $recipe->id }}">
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->title }}" title="Перейти к рецепту">
                        </a>
                        <div class="each-content">
                            <span>{{ $recipe->title }}</span>
                            <span>{{ $recipe->intro }}</span>
                        </div>
                    </div>
                @endforeach
                {{ $unapproved->links() }}
            @else
                <p class="content">Нет непровереных рецептов.</p>
            @endif
        </div>
    @endif
</div>

<script>
    let notification = document.querySelector(".notification")

    notification.addEventListener('click', animateNotification)

    function animateNotification() {
        notification.classList.add("disappear")
        notification.style.opacity = '0'
    }
</script>

@endsection