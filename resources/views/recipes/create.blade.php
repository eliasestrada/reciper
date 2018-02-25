@extends('layouts.app')

@section('content')

<div class="wrapper">

    {!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

        <h2>Добавление рецепта</h2>

        <div class="form-group">
            {{ Form::label('название', 'Название') }}
            {{ Form::text('название', '', ['placeholder' => 'Название']) }}
        </div>

        <div class="form-group">
            {{ Form::label('описание', 'Описание') }}
            {{ Form::textarea('описание', '', ['placeholder' => 'Описание']) }}
        </div>

        <div class="form-group">
            {{ Form::label('ингридиенты', 'Ингридиенты') }}
            {{ Form::textarea('ингридиенты', '', ['placeholder' => 'Ингридиенты']) }}
        </div>

        <div class="form-group">
            {{ Form::label('совет', 'Совет') }}
            {{ Form::textarea('совет', '', ['placeholder' => 'Совет']) }}
        </div>

        <div class="form-group">
            {{ Form::label('приготовление', 'Приготовление') }}
            {{ Form::textarea('приготовление', '', ['placeholder' => 'Приготовление']) }}
        </div>
        
        <div class="form-group">
            {{ Form::label('категория', 'Категория') }}
        </div>

        <div class="form-group">
            <select name="категория">
                @foreach ($categories as $category)
                    <option selected value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {{ Form::label('время', 'Время приготовления в минутах') }}
            {{ Form::number('время', '0') }}
        </div>

        <div class="form-group">
            {{ Form::file('изображение') }}
        </div>

        <div class="form-group">
            {{ Form::submit('Сохранить') }}
        </div>

    {!! Form::close() !!}
</div>

@endsection