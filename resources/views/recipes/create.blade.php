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
			@component('components.forms.text_field')
			@endcomponent
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
		<div class="col-12 col-md-6">
			@component('components.forms.image_field')
			@endcomponent
		</div>
	</div>
</form>

@endsection