@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

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
			<p>@lang('recipes.ready_to_publish')</p>
		</div>
	</div>

	<h2 class="headline">@lang('recipes.add_recipe')</h2>

	<button class="accordion" type="button">@lang('recipes.title')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('title', trans('recipes.title')) }}
			{{ Form::text('title', $recipe->title, ['placeholder' => trans('recipes.title')]) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.intro')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('intro', trans('recipes.intro')) }}
			{{ Form::textarea('intro', $recipe->intro, ['placeholder' => trans('recipes.short_intro')]) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.ingredients')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('ingredients', trans('recipes.ingredients')) }}
			{{ Form::textarea('ingredients', $recipe->ingredients, ['placeholder' => trans('recipes.ingredients_description')]) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.advice')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('advice', trans('recipes.advice')) }}
			{{ Form::textarea('advice', $recipe->advice, ['placeholder' => trans('recipes.advice_description')]) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.text_of_recipe')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('text', trans('recipes.text_of_recipe')) }}
			{{ Form::textarea('text', $recipe->text, ['placeholder' => trans('recipes.text_description')]) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.category')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('category', trans('recipes.category')) }}
			<select name="category">
				@foreach ($categories as $category)
					<option selected value="{{ $category->category }}">{{ $category->category }}</option>
				@endforeach
				<option selected value="{{ $recipe->category }}">{{ $recipe->category }}</option>
			</select>
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.time')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('time', trans('recipes.time_description')) }}
			{{ Form::number('time', $recipe->time) }}
		</div>
	</div>

	<button class="accordion" type="button">@lang('recipes.image')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('src-image', trans('recipes.select_file'), ['class' => 'image-label']) }}
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