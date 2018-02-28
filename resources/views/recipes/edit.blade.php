@extends('layouts.app')

@section('content')

<div class="wrapper">
    {!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

        <div class="recipe-buttons">
            {{--  Save button  --}}
            {{ Form::submit('&#xf0c7;', ['class' => "fa"]) }}

            {{--  View button  --}}
            <a href="/recipes/{{ $recipe->id }}"><i class="fa">&#xf06e;</i></a>
        </div>


        <div class="check-box-ready">
            <div class="check-box-ready-wrap">
                {{ Form::checkbox('ready', 1, null) }}
                <p>Готово к публикации</p>
            </div>
        </div>

        <h2>Добавление рецепта</h2>

        <button class="accordion" type="button">Название</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('название', 'Название') }}
                {{ Form::text('название', $recipe->title, ['placeholder' => 'Название рецепта']) }}
            </div>
        </div>

        <button class="accordion" type="button">Описание</button>
        <div class="panel">
            <div class="form-group">
                    {{ Form::label('описание', 'Описание') }}
                    {{ Form::textarea('описание', $recipe->intro, ['placeholder' => 'Краткое описание рецепта']) }}
            </div>
        </div>

        <button class="accordion" type="button">Ингридиенты</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('ингридиенты', 'Ингридиенты') }}
                {{ Form::textarea('ингридиенты', $recipe->ingredients, ['placeholder' => 'Все ингридиенты рецепта. После каждого ингридиента нажимайте кнопку Ввод (Enter) чтобы разделить их на строки.']) }}
            </div>
        </div>

        <button class="accordion" type="button">Совет</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('совет', 'Совет') }}
                {{ Form::textarea('совет', $recipe->advice, ['placeholder' => 'Это поле не обязательно к заполнению, если у вас есть просьба или совет который может помочь в приготовлении блюда пишите его сюда.']) }}
            </div>
        </div>

        <button class="accordion" type="button">Приготовление</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('приготовление', 'Приготовление') }}
                {{ Form::textarea('приготовление', $recipe->text, ['placeholder' => 'Опишите процесс приготовления по пунктам используя Ввод (Enter) для отделения пунктов друг от друга.']) }}
            </div>
        </div>

        <button class="accordion" type="button">Категория</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('категория', 'Категория') }}
                <select name="категория">
                    @foreach ($categories as $category)
                        <option selected value="{{ $category->category }}">{{ $category->category }}</option>
                    @endforeach
                    <option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
                </select>
            </div>
        </div>

        <button class="accordion" type="button">Время приготовления</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('время', 'Время приготовления в минутах') }}
                {{ Form::number('время', $recipe->time) }}
            </div>
        </div>

        <button class="accordion" type="button">Изображение</button>
        <div class="panel">
            <div class="form-group">
                {{ Form::label('изображение', 'Изображение не должно быть высокого разрешения.') }}
                {{ Form::file('изображение', ['class' => "upload-image-form"]) }}
                {{ Form::hidden('_method', 'PUT') }}

                <div class="form-group">
                    <section class="recipes">
                        <div>
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" title="{{$recipe->title}}">
                        </div>
                    </section>
                </div>

            </div>
        </div>

    {!! Form::close() !!}
</div>

<script>
// Dropdowns
var acc = document.getElementsByClassName("accordion")
var i

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function(){
        this.classList.toggle("active")
        var panel = this.nextElementSibling

        if (panel.style.maxHeight) {
            panel.style.maxHeight = null
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px"
        } 
    })
}
</script>

@endsection