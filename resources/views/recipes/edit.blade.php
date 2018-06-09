@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="form" enctype="multipart/form-data" id="form-update-recipe">

	@method('put')
	@csrf

	<div class="row">
		<div class="col-12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>
			<div class="recipe-buttons">
				{{--  Save button  --}}
				<input type="submit" id="submit-save-recipe" class="edit-recipe-icon icon-save" title="@lang('recipes.save_recipe')" value="">
	
				{{--  View button  --}}
				<a href="/recipes/{{ $recipe->id }}" class="edit-recipe-icon icon-eye" title="@lang('recipes.view_recipe')"></a>

				{{-- Publish button --}}
				<a href="#" class="edit-recipe-icon icon-publish" title="@lang('recipes.view_recipe')" id="publish-btn"></a>
				<input type="checkbox" name="ready" value="1" class="d-none" id="ready-checkbox">

				{{--  Delete button  --}}
				<delete-recipe-btn
					recipe-id="{{ $recipe->id }}"
					deleted-fail="{{ trans('recipes.deleted_fail') }}"
					deleting="{{ trans('recipes.deleting') }}"
					confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
				</delete-recipe-btn>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-md-4">
			{{-- Title --}}
			<div class="form-group">
				<label for="title">@lang('recipes.title')</label>
				<input type="text" name="title" id="title" placeholder="@lang('recipes.title')" value="{{ $recipe->toArray()['title_'.locale()] }}">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4">
			{{-- Time --}}
			<div class="form-group simple-group">
				<label for="time">@lang('recipes.time_description')</label>
				<input type="number" name="time" id="time" value="{{ $recipe->time }}">
			</div>
		</div>
		<div class="col-12 col-sm-6 col-md-4">
			{{-- Meal time --}}
			<div class="form-group simple-group">
				<label for="meal">@lang('recipes.meal_description')</label>
				<select name="meal" id="meal">
					@foreach ($meal as $m)
						<option value="{{ $m['id'] }}" {{ selectedIfEqual($m['id'], $recipe->meal->id) }}>
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
				<textarea name="ingredients" id="ingredients" placeholder="@lang('recipes.ingredients_description')">{{ $recipe->toArray()['ingredients_'.locale()] }}</textarea>
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Advice --}}
			<div class="form-group">
				<label for="intro">@lang('recipes.intro')</label>
				<textarea name="intro" id="intro" placeholder="@lang('recipes.short_intro')">{{ $recipe->toArray()['intro_'.locale()] }}</textarea>
			</div>
		</div>

		<div class="col-12 mb-2">
			{{-- Text --}}
			<div class="form-group">
				<label for="text">@lang('recipes.text_of_recipe')</label>
				<textarea name="text" id="text" placeholder="@lang('recipes.text_description')">{{ $recipe->toArray()['text_'.locale()] }}</textarea>
			</div>
		</div>

		<div class="form-group col-12 col-md-6 pb-5" style="border-bottom:solid 1px lightgray;">
			<categories-field
				locale="{{ locale() }}"
				:recipe-categories="{{ json_encode($recipe->categories) }}"
				label="@lang('recipes.category')"
				select="@lang('form.select')"
				categories-title="@lang('recipes.categories_title')"
				deleting="@lang('form.deleting')"
				add="@lang('form.add')">
			</categories-field>
		</div>

		{{-- Image --}}
		@component('components.forms.add_image')
			@slot('image')
				{{ $recipe->image }}
			@endslot
			@slot('alt')
				{{ $recipe->title }}
			@endslot
		@endcomponent
	</div>
</form>

@endsection