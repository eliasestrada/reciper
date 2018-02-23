@extends('layouts.app')
@section('content')

    <h1>Добавление рецепта</h1>
    {!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
        <p>
            {{ Form::label('название', 'Название') }}</p>
            {{ Form::text('название', '', ['placeholder' => 'Название']) }}
        </p>
        <p>
            {{ Form::label('описание', 'Описание') }}</p>
            {{ Form::textarea('описание', '', ['placeholder' => 'Описание']) }}
        </p>
        <p>
            {{ Form::file('изображение') }}
        </p>
        {{ Form::submit('Сохранить', ['class' => 'button']) }}</p>
    {!! Form::close() !!}

@endsection