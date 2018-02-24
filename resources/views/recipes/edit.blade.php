@extends('layouts.app')
@section('content')

    <h1>Редактирование рецепта</h1>
    {!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
        <p>
            {{ Form::label('название', 'Название') }}
            {{ Form::text('название', $recipe->title, ['placeholder' => 'Название']) }}
        </p>
        <p>
            {{ Form::label('описание', 'Описание') }}
            {{ Form::textarea('описание', $recipe->intro, ['placeholder' => 'Описание']) }}
        </p>
        <p>
            {{ Form::label('ингридиенты', 'Ингридиенты') }}
            {{ Form::textarea('ингридиенты', $recipe->ingredients, ['placeholder' => 'Ингридиенты']) }}
        </p>
        <p>
            {{ Form::label('совет', 'Совет') }}
            {{ Form::textarea('совет', $recipe->advice, ['placeholder' => 'Совет']) }}
        </p>
        <p>
            {{ Form::label('приготовление', 'Приготовление') }}
            {{ Form::textarea('приготовление', $recipe->text, ['placeholder' => 'Приготовление']) }}
        </p>
        <p>
            {{ Form::label('категория', 'Категория') }}

            <select name="категория">
                @foreach ($categories as $category)
                    <option selected value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
                <option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
            </select>
        <p>
            {{ Form::label('время', 'Время приготовления в минутах') }}
            {{ Form::number('время', $recipe->time) }}
        </p>
        {{ Form::hidden('_method', 'PUT') }}
        <p>
            {{ Form::file('изображение', ['class' => "upload-image-form"]) }}
        </p>
        {{ Form::submit('Сохранить', ['class' => 'button']) }}
    {!! Form::close() !!}

@endsection