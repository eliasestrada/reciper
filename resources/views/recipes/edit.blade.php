@extends('layouts.app')

@section('title', 'Редактировать')

@section('content')

{!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	@method('PUT')

	<div class="recipe-buttons">
		{{--  Save button  --}}
		{{ Form::submit('', ['class' => "edit-recipe-icon icon-save"]) }}

		{{--  View button  --}}
		<a href="/recipes/{{ $recipe->id }}" class="edit-recipe-icon icon-eye"></a>
	</div>

	<div class="check-box-ready">
		<div class="check-box-ready-wrap">
			{{ Form::checkbox('ready', 1, null) }}
			<p>Готово к публикации</p>
		</div>
	</div>

	<h2 class="headline">Добавление рецепта</h2>

	<button class="accordion" type="button">Название</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('title', 'Название') }}
			{{ Form::text('title', $recipe->title, ['placeholder' => 'Название рецепта']) }}
		</div>
	</div>

	<button class="accordion" type="button">Описание</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('intro', 'Описание') }}
			{{ Form::textarea('intro', $recipe->intro, ['placeholder' => 'Краткое описание рецепта']) }}
		</div>
	</div>

	<button class="accordion" type="button">Ингридиенты</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('ingredients', 'Ингридиенты') }}
			{{ Form::textarea('ingredients', $recipe->ingredients, ['placeholder' => 'Все ингридиенты рецепта. После каждого ингридиента нажимайте кнопку Ввод (Enter) чтобы разделить их на строки.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Совет</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('advice', 'Совет') }}
			{{ Form::textarea('advice', $recipe->advice, ['placeholder' => 'Это поле не обязательно к заполнению, если у вас есть просьба или совет который может помочь в приготовлении блюда пишите его сюда.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Приготовление</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('text', 'Приготовление') }}
			{{ Form::textarea('text', $recipe->text, ['placeholder' => 'Опишите процесс приготовления по пунктам используя Ввод (Enter) для отделения пунктов друг от друга.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Категория</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('category', 'Категория') }}
			<select name="category simple-group">
				@foreach ($categories as $category)
					<option selected value="{{ $category->category }}">{{ $category->category }}</option>
				@endforeach
				<option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
			</select>
		</div>
	</div>

	<button class="accordion" type="button">Время приготовления</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('time', 'Время приготовления в минутах') }}
			{{ Form::number('time', $recipe->time) }}
		</div>
	</div>

	<button class="accordion" type="button">Изображение</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('src-image', 'Выбрать файл', ['class' => 'image-label']) }}
			{{ Form::file('image', ['style' => "display:none;", "id" => "src-image"]) }}

			<section class="preview-image">
				<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" id="target-image">
			</section>
		</div>
	</div>

{!! Form::close() !!}

@endsection

@section('script')
<script defer>
	var acc = document.getElementsByClassName("accordion")
	var src = document.getElementById("src-image")
	var target = document.getElementById("target-image")
	var i

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function(){
			this.classList.toggle("accordion-active")
			var panel = this.nextElementSibling

			if (panel.style.maxHeight) {
				panel.style.maxHeight = null
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px"
			} 
		})
	}

	function showImage(src, target) {
		var fr = new FileReader()
		
		fr.onload = function(e) { target.src = this.result }
		src.addEventListener("change", ()=> fr.readAsDataURL(src.files[0]))
	}

	showImage(src, target)
</script>
@endsection