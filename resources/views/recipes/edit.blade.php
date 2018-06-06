@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="form" enctype="multipart/form-data">

	@method('put')
	@csrf

	<div class="row">
		<div class="col-12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>
			<div class="recipe-buttons">
				{{--  Save button  --}}
				<input type="submit" id="submit-save-recipe" class="edit-recipe-icon icon-save" value="">
	
				{{--  View button  --}}
				<a href="/recipes/{{ $recipe->id }}" class="edit-recipe-icon icon-eye"></a>
			</div>
		</div>

		<div class="check-box-ready d-flex col-12">
			<div class="d-flex">
				<input type="checkbox" name="ready" value="1">
				<p>@lang('recipes.ready_to_publish')</p>
			</div>
		</div>

		<div class="col-12 col-md-4">
			{{-- Title --}}
			<div class="form-group">
				<label for="title">@lang('recipes.title')</label>
				<input type="text" name="title" id="title" placeholder="@lang('recipes.title')" value="{{ $recipe->title }}">
			</div>
		</div>
		<div class="col-12 col-md-4">
			{{-- Category --}}
			<div class="form-group simple-group">
				<label for="category_id">@lang('recipes.category')</label>
				<select name="category_id" id="category_id">
					<option selected value="{{ $recipe->category->id }}">{{ $category }}</option>
					<option>--------------------------</option>
					@foreach ($categories as $category)
						<option value="{{ $category->id }}">
							{{ $category->toArray()['name_'.locale()] }}
						</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-12 col-md-4">
			{{-- Time --}}
			<div class="form-group simple-group">
				<label for="time">@lang('recipes.time_description')</label>
				<input type="number" name="time" id="time" value="{{ $recipe->time }}">
			</div>
		</div>

		<div class="col-12 col-lg-6">
			{{-- Ingredients --}}
			<div class="form-group">
				<label for="ingredients">@lang('recipes.ingredients')</label>
				<textarea name="ingredients" id="ingredients" placeholder="@lang('recipes.ingredients_description')">
					{{ $recipe->ingredients }}
				</textarea>
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Advice --}}
			<div class="form-group">
				<label for="intro">@lang('recipes.intro')</label>
				<textarea name="intro" id="intro" placeholder="@lang('recipes.short_intro')">
					{{ $recipe->intro }}
				</textarea>
			</div>
		</div>

		<div class="col-12">
			{{-- Intro --}}
			<div class="form-group">
				<label for="text">@lang('recipes.text_of_recipe')</label>
				<textarea name="text" id="text" placeholder="@lang('recipes.text_description')">
					{{ $recipe->text }}
				</textarea>
			</div>
		</div>

		{{-- Image --}}
		<div class="form-group simple-group text-center col-12">
			<div class="row">
				<div class="col-md-4 offset-md-2">
					<label for="src-image" class="image-label mt-3">@lang('recipes.select_file')</label>
					<input type="file" name="image" id="src-image" class="d-none">
				</div>
				<div class="col-md-4">
					<section class="preview-image">
						<img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{$recipe->title}}" id="target-image">
					</section>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection