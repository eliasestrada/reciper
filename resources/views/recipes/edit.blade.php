@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

{!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	@method('PUT')

	<div class="recipe-buttons">
		{{--  Save button  --}}
		<input type="submit" id="submit-save-recipe" class="edit-recipe-icon icon-save" value="">

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

	{{-- Title --}}
	<button class="accordion" type="button">@lang('recipes.title')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('title', trans('recipes.title')) }}
			{{ Form::text('title', $recipe->title, ['placeholder' => trans('recipes.title')]) }}
		</div>
	</div>

	{{-- Intro --}}
	<button class="accordion" type="button">@lang('recipes.intro')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('intro', trans('recipes.intro')) }}
			{{ Form::textarea('intro', $recipe->intro, ['placeholder' => trans('recipes.short_intro')]) }}
		</div>
	</div>

	{{-- Ingredients --}}
	<button class="accordion" type="button">@lang('recipes.ingredients')</button>
	<div class="accordion-panel">
		<div class="form-group">
			{{ Form::label('ingredients', trans('recipes.ingredients')) }}
			{{ Form::textarea('ingredients', $recipe->ingredients, ['placeholder' => trans('recipes.ingredients_description')]) }}
		</div>
	</div>

	{{-- Advice --}}
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

	{{-- Category --}}
	<button class="accordion" type="button">@lang('recipes.category')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('category', trans('recipes.category')) }}
			<select name="category_id">
				<option selected value="{{ $recipe->category->id }}">{{ $recipe->category->category }}</option>
				<option>--------------------------</option>
				@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->category }}</option>
				@endforeach
			</select>
		</div>
	</div>

	{{-- Time --}}
	<button class="accordion" type="button">@lang('recipes.time')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group">
			{{ Form::label('time', trans('recipes.time_description')) }}
			{{ Form::number('time', $recipe->time) }}
		</div>
	</div>

	{{-- Image --}}
	<button class="accordion" type="button">@lang('recipes.image')</button>
	<div class="accordion-panel">
		<div class="form-group simple-group" style="text-align:center;">
			{{ Form::label('src-image', trans('recipes.select_file'), ['class' => 'image-label']) }}
			{{ Form::file('image', ['style' => "display:none;", "id" => "src-image"]) }}

			<section class="preview-image">
				<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" id="target-image">
			</section>
		</div>
	</div>

{!! Form::close() !!}

@endsection