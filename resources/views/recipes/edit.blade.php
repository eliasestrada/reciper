@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

{!! Form::open(['action' => ['RecipesController@update', $recipe->id], 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}

	@method('PUT')

	<div class="row">
		<div class="col-12">
			<div class="recipe-buttons">
				{{--  Save button  --}}
				<input type="submit" id="submit-save-recipe" class="edit-recipe-icon icon-save" value="">
	
				{{--  View button  --}}
				<a href="/recipes/{{ $recipe->id }}" class="edit-recipe-icon icon-eye"></a>
			</div>
		</div>

		<div class="check-box-ready col-12">
			<div class="check-box-ready-wrap">
				{{ Form::checkbox('ready', 1, null) }}
				<p>@lang('recipes.ready_to_publish')</p>
			</div>
		</div>

		<h2 class="headline col-12">@lang('recipes.add_recipe')</h2>

		<div class="col-12 col-md-4">
			{{-- Title --}}
			<div class="form-group">
				{{ Form::label('title', trans('recipes.title')) }}
				{{ Form::text('title', $recipe->title, ['placeholder' => trans('recipes.title')]) }}
			</div>
		</div>
		<div class="col-12 col-md-4">
			{{-- Category --}}
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
		<div class="col-12 col-md-4">
			{{-- Time --}}
			<div class="form-group simple-group">
				{{ Form::label('time', trans('recipes.time_description')) }}
				{{ Form::number('time', $recipe->time) }}
			</div>
		</div>

		<div class="col-12 col-lg-6">
			{{-- Ingredients --}}
			<div class="form-group">
				{{ Form::label('ingredients', trans('recipes.ingredients')) }}
				{{ Form::textarea('ingredients', $recipe->ingredients, ['placeholder' => trans('recipes.ingredients_description')]) }}
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Advice --}}
			<div class="form-group">
				{{ Form::label('advice', trans('recipes.advice')) }}
				{{ Form::textarea('advice', $recipe->advice, ['placeholder' => trans('recipes.advice_description')]) }}
			</div>
		</div>

		<div class="col-12 col-lg-6">
			{{-- Intro --}}
			<div class="form-group">
				{{ Form::label('intro', trans('recipes.intro')) }}
				{{ Form::textarea('intro', $recipe->intro, ['placeholder' => trans('recipes.short_intro')]) }}
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Text --}}
			<div class="form-group">
				{{ Form::label('text', trans('recipes.text_of_recipe')) }}
				{{ Form::textarea('text', $recipe->text, ['placeholder' => trans('recipes.text_description')]) }}
			</div>
		</div>

		{{-- Image --}}
		<div class="form-group simple-group col-12" style="text-align:center;">
			<div class="row">
				<div class="col-md-4 offset-md-2">
					{{ Form::label('src-image', trans('recipes.select_file'), ['class' => 'image-label', 'style' => 'margin-top:1.5em;']) }}
					{{ Form::file('image', ['style' => "display:none;", "id" => "src-image"]) }}
				</div>
				<div class="col-md-4">
					<section class="preview-image">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" id="target-image">
					</section>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}

@endsection