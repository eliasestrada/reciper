@extends('layouts.app')

@section('title', 'Написать')

@section('content')

{!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	<div class="recipe-buttons">
		{{ Form::submit('', ['class' => "edit-recipe-icon icon-save"]) }}
	</div>

	<h2 class="headline">Добавление рецепта</h2>

	<button class="accordion" type="button">Название</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::text('название', '', ['placeholder' => 'Название рецепта']) }}
		</div>
	</div>
	
	<button class="accordion" type="button">Описание</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::textarea('описание', '', ['placeholder' => 'Краткое описание рецепта']) }}
		</div>
	</div>
	
	<button class="accordion" type="button">Ингридиенты</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::textarea('ингридиенты', '', ['placeholder' => 'Все ингридиенты рецепта. После каждого ингридиента нажимайте кнопку Ввод (Enter) чтобы разделить их на строки.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Совет</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::textarea('совет', '', ['placeholder' => 'Это поле не обязательно к заполнению, если у вас есть просьба или совет который может помочь в приготовлении блюда пишите его сюда.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Приготовление</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::textarea('приготовление', '', ['placeholder' => 'Опишите процесс приготовления по пунктам используя Ввод (Enter) для отделения пунктов друг от друга.']) }}
		</div>
	</div>

	<button class="accordion" type="button">Категория</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			<select name="категория">
				@foreach ($categories as $category)
					<option selected value="{{ $category->category }}">{{ $category->category }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<button class="accordion" type="button">Время приготовления</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('время', 'Время приготовления в минутах') }}
			{{ Form::number('время', '0') }}
		</div>
	</div>

	<button class="accordion" type="button">Изображение</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('src-image', 'Выбрать файл', ['class' => 'image-label']) }}
			{{ Form::file('изображение', ['style' => "display:none;", "id" => "src-image"]) }}
			
			<section class="preview-image">
					<img src="{{ asset('storage/images/default.jpg') }}" alt="Изображение" id="target-image">
			</section>
		</div>
	</div>

{!! Form::close() !!}

@endsection

@section('script')
<script defer>
	// Dropdowns
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