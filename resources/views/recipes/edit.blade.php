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

		{{-- Time --}}
		<div class="col-12 col-sm-6 col-md-4">
			@component('comps.forms.time_field')
				@slot('time')
					{{ $recipe->time }}
				@endslot
			@endcomponent
		</div>

		{{-- Meal time --}}
		<div class="col-12 col-sm-6 col-md-4">
			@component('comps.forms.meal_field', ['meal' => $meal])
				@slot('meal_id')
					{{ $recipe->meal->id }}
				@endslot
			@endcomponent
		</div>

		{{-- Ingredients --}}
		<div class="col-12 col-lg-6">
			@component('comps.forms.ingredients_field')
				@slot('ingredients')
					{{ $recipe->toArray()['ingredients_'.locale()] }}
				@endslot
			@endcomponent
		</div>

		{{-- Advice --}}
		<div class="col-12 col-lg-6">
			@component('comps.forms.intro_field')
				@slot('intro')
					{{ $recipe->toArray()['intro_'.locale()] }}
				@endslot
			@endcomponent
		</div>

		{{-- Text --}}
		<div class="col-12 mb-2">
			@component('comps.forms.text_field')
				@slot('text')
					{{ $recipe->toArray()['text_'.locale()] }}
				@endslot
			@endcomponent
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
		<div class="col-12 col-md-6">
			@component('comps.forms.image_field')
				@slot('image')
					{{ $recipe->image }}
				@endslot
				@slot('alt')
					{{ $recipe->title }}
				@endslot
			@endcomponent
		</div>
	</div>
</form>

@endsection