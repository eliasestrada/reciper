@extends('layouts.app')
@section('content')

    <h1>Редактирование рецепта</h1>
    {!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form']) !!}
        <p>
            {{ Form::label('название', 'Название') }}</p>
            {{ Form::text('название', $recipe->title, ['placeholder' => 'Название']) }}
        </p>
        <p>
            {{ Form::label('описание', 'Описание') }}</p>
            {{ Form::textarea('описание', $recipe->intro, ['placeholder' => 'Описание']) }}
        </p>
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Сохранить', ['class' => 'button']) }}</p>
    {!! Form::close() !!}

@endsection