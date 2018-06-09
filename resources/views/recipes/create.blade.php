@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@store') }}" method="post" class="form" enctype="multipart/form-data">
	<div class="row">

		@csrf

		<div class="col-12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>
			{{-- Edit button --}}
			<div class="recipe-buttons col-12">
				<button type="submit" class="edit-recipe-icon icon-save"></button>
			</div>
		</div>
	
		<div class="col-12 col-sm-6 col-md-4">
			{{-- Title --}}
			<div class="form-group">
				<label for="title">@lang('recipes.title')</label>
				<input type="text" name="title" placeholder="@lang('recipes.title')" id="title">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4">
			{{-- Time --}}
			<div class="form-group simple-group">
				<label for="time">@lang('recipes.time_description')</label>
				<input name="time" type="number" value="0" id="time">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4">
			{{-- Meal time --}}
			<div class="form-group simple-group">
				<label for="meal">@lang('recipes.meal_description')</label>
				<select name="meal" id="meal">
					@foreach ($meal as $m)
						<option value="{{ $m['id'] }}">
							{{ title_case($m['name_'.locale()]) }}
						</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-12 col-lg-6">
			{{-- Ingredients --}}
			<div class="form-group">
				<label for="ingredients">@lang('recipes.ingredients')</label>
				<textarea name="ingredients" placeholder="@lang('recipes.ingredients_description')" id="ingredients"></textarea>
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Advice --}}
			<div class="form-group">
				<label for="intro">@lang('recipes.intro')</label>
				<textarea name="intro" placeholder="@lang('recipes.short_intro')" id="intro"></textarea>
			</div>
		</div>

		<div class="col-12 mb-2">
			{{-- Text --}}
			<div class="form-group">
				<label for="text">@lang('recipes.text_of_recipe')</label>
				<textarea name="text" placeholder="@lang('recipes.text_description')" id="text"></textarea>
			</div>
		</div>

		<div class="form-group col-12 col-md-6 pb-5" style="border-bottom:solid 1px lightgray;">
			<categories-field
				locale="{{ locale() }}"
				label="@lang('recipes.category')"
				select="@lang('form.select')"
				categories-title="@lang('recipes.categories_title')"
				deleting="@lang('form.deleting')"
				add="@lang('form.add')">
			</categories-field>
		</div>

		{{-- Image --}}
		<div class="form-group simple-group text-center col-12 col-md-6 pb-5" style="border-bottom:solid 1px lightgray;">
			<h3 class="col-12 text-center mb-2">@lang('recipes.image')</h3>
			<label for="src-image" class="image-label" title="{{ trans('recipes.select_file') }}">@lang('recipes.select_file')</label>
			<input type="file" name="image" id="src-image" class="d-none">

			<section class="preview-image">
				<img src="{{ asset('storage/images/default.jpg') }}" alt="@lang('recipes.image')" id="target-image">
			</section>
		</div>
	</div>
</form>

@endsection