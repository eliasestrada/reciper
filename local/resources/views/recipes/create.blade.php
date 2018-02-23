@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Добавление рецепта</h1>
        <div class="form">
            {!! Form::open(['action' => 'RecipesController@store', 'method' => 'post']) !!}
                <p>
                    {{ Form::label('title', 'Название') }}</p>
                    {{ Form::text('title', '', ['placeholder' => 'Название']) }}
                </p>
                <p>
                    {{ Form::label('intro', 'Краткое описание') }}</p>
                    {{ Form::textarea('intro', '', ['placeholder' => 'Краткое описание']) }}
                </p>
                {{ Form::submit('Сохранить', ['class' => 'button']) }}</p>
            {!! Form::close() !!}
        </div>
    </div>
@endsection