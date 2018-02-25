@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h1>Добавление рецепта</h1>
    {!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

        {{ Form::label('название', 'Название') }}
        {{ Form::text('название', '', ['placeholder' => 'Название']) }}


        {{ Form::label('описание', 'Описание') }}
        {{ Form::textarea('описание', '', ['placeholder' => 'Описание']) }}

        {{ Form::label('ингридиенты', 'Ингридиенты') }}
        {{ Form::textarea('ингридиенты', '', ['placeholder' => 'Ингридиенты']) }}

        {{ Form::label('совет', 'Совет') }}
        {{ Form::textarea('совет', '', ['placeholder' => 'Совет']) }}

        {{ Form::label('приготовление', 'Приготовление') }}
        {{ Form::textarea('приготовление', '', ['placeholder' => 'Приготовление']) }}

        {{ Form::label('категория', 'Категория') }}

        <select name="категория">
            @foreach ($categories as $category)
                <option selected value="{{ $category->category }}">{{ $category->category }}</option>
            @endforeach
        </select>

        {{ Form::label('время', 'Время приготовления в минутах') }}
        {{ Form::number('время', '0') }}

        {{ Form::file('изображение') }}
        {{ Form::submit('Сохранить') }}
    {!! Form::close() !!}
</div>

@endsection