@extends('layouts.app')
@section('content')

    <h1>Добавление рецепта</h1>
    {!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
        <p>
            {{ Form::label('название', 'Название') }}
            {{ Form::text('название', '', ['placeholder' => 'Название']) }}
        </p>
        <p>
            {{ Form::label('описание', 'Описание') }}
            {{ Form::textarea('описание', '', ['placeholder' => 'Описание']) }}
        </p>
        <p>
            {{ Form::label('ингридиенты', 'Ингридиенты') }}
            {{ Form::textarea('ингридиенты', '', ['placeholder' => 'Ингридиенты']) }}
        </p>
        <p>
            {{ Form::label('совет', 'Совет') }}
            {{ Form::textarea('совет', '', ['placeholder' => 'Совет']) }}
        </p>
        <p>
            {{ Form::label('приготовление', 'Приготовление') }}
            {{ Form::textarea('приготовление', '', ['placeholder' => 'Приготовление']) }}
        </p>
        <p>
            {{ Form::label('категория', 'Категория') }}

            <select name="категория">
                @foreach ($categories as $category)
                    <option selected value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
        <p>
        </p>
        <p>
            {{ Form::label('время', 'Время приготовления в минутах') }}
            {{ Form::number('время', '0') }}
        </p>
        <p>
            {{ Form::file('изображение') }}
        </p>
        {{ Form::submit('Сохранить', ['class' => 'button']) }}
    {!! Form::close() !!}

@endsection