@extends('layouts.app')

@section('content')

<div class="wrapper">
    <div class="content">
        <h2>Панель управления</h2>
        <h3>{{ Auth::user()->name }}</h3>
    </div>

    <a href="{{ url('/recipes/create') }}" title="Добавить рецепт" class="button">Добавить рецепт</a>

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
        <div style="background: url('{{ asset('storage/other/people.jpg') }}');">
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


{{--
    @if (count($recipes) > 0)
        @foreach ($recipes as $recipe)
            <tr>
                <td>
                    <p class="content">{{ $recipe->title }}</p>
                </td>
                <td>
                    <a href="{{ url('/recipes/'.$recipe->id.'/edit') }}">Изменить</a>
                </td>
                <td>
                    {!! Form::open(['action' => ['RecipesController@destroy', $recipe->id], 'method' => 'post']) !!}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete') }}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @else
        <p class="content">У вас еще нет рецептов.</p>
    @endif
--}}
