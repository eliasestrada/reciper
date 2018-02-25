@extends('layouts.app')

@section('content')

<div class="wrapper">
    <h1>Редактирование рецепта</h1>

    {!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group">
            {{ Form::label('название', 'Название') }}
            {{ Form::text('название', $recipe->title, ['placeholder' => 'Название']) }}
        </div>

        <div class="form-group">
            {{ Form::label('описание', 'Описание') }}
            {{ Form::textarea('описание', $recipe->intro, ['placeholder' => 'Описание']) }}
        </div>

        <div class="form-group">
            {{ Form::label('ингридиенты', 'Ингридиенты') }}
            {{ Form::textarea('ингридиенты', $recipe->ingredients, ['placeholder' => 'Ингридиенты']) }}
        </div>

        <div class="form-group">
            {{ Form::label('совет', 'Совет') }}
            {{ Form::textarea('совет', $recipe->advice, ['placeholder' => 'Совет']) }}
        </div>

        <div class="form-group">
            {{ Form::label('приготовление', 'Приготовление') }}
            {{ Form::textarea('приготовление', $recipe->text, ['placeholder' => 'Приготовление']) }}
        </div>

        <div class="form-group">
            {{ Form::label('категория', 'Категория') }}
        </div>

        <div class="form-group">
            <select name="категория">
                @foreach ($categories as $category)
                    <option selected value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
                <option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
            </select>
        </div>

        <div class="form-group">
            {{ Form::label('время', 'Время приготовления в минутах') }}
            {{ Form::number('время', $recipe->time) }}
        </div>

        <div class="form-group">
            <section class="recipes">
                <div>
                    <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" title="{{$recipe->title}}">
                </div>
            </section>
        </div>

        <div class="form-group">
            {{ Form::file('изображение', ['class' => "upload-image-form"]) }}
        </div>

        <div class="form-group">
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit('Сохранить') }}
        </div>

    {!! Form::close() !!}
</div>

@endsection