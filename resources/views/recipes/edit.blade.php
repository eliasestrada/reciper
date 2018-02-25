@extends('layouts.app')
@section('content')

    <h1>Редактирование рецепта</h1>
    {!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

        {{ Form::label('название', 'Название') }}
        {{ Form::text('название', $recipe->title, ['placeholder' => 'Название']) }}

        {{ Form::label('описание', 'Описание') }}
        {{ Form::textarea('описание', $recipe->intro, ['placeholder' => 'Описание']) }}

        {{ Form::label('ингридиенты', 'Ингридиенты') }}
        {{ Form::textarea('ингридиенты', $recipe->ingredients, ['placeholder' => 'Ингридиенты']) }}

        {{ Form::label('совет', 'Совет') }}
        {{ Form::textarea('совет', $recipe->advice, ['placeholder' => 'Совет']) }}

        {{ Form::label('приготовление', 'Приготовление') }}
        {{ Form::textarea('приготовление', $recipe->text, ['placeholder' => 'Приготовление']) }}

        {{ Form::label('категория', 'Категория') }}
        <select name="категория">
            @foreach ($categories as $category)
                <option selected value="{{ $category->category }}">{{ $category->category }}</option>
            @endforeach
            <option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
        </select>

        {{ Form::label('время', 'Время приготовления в минутах') }}
        {{ Form::number('время', $recipe->time) }}

        <!-- Image -->
        <section class="recipes">
            <div>
                <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" title="{{$recipe->title}}">
            </div>
        </section>

        {{ Form::file('изображение', ['class' => "upload-image-form"]) }}

        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Сохранить') }}
    {!! Form::close() !!}

@endsection