@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@store') }}" method="post" class="form" enctype="multipart/form-data">
	<div class="row">

		@csrf

		{{-- Edit button --}}
		<div class="col-12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>
			<div class="recipe-buttons col-12">
				<button type="submit" class="edit-recipe-icon icon-save"></button>
			</div>
		</div>
	
		{{-- Title --}}
		<div class="col-12 col-sm-6 col-md-4">
			@component('comps.forms.title_field')
			@endcomponent
		</div>

		{{-- Time --}}
		<div class="col-12 col-sm-6 col-md-4">
			@component('comps.forms.time_field')
			@endcomponent
		</div>

		{{-- Meal time --}}
		<div class="col-12 col-sm-6 col-md-4">
			@component('comps.forms.meal_field', ['meal' => $meal])
			@endcomponent
		</div>

		{{-- Ingredients --}}
		<div class="col-12 col-lg-6">
			@component('comps.forms.ingredients_field')
			@endcomponent
		</div>

		{{-- Advice --}}
		<div class="col-12 col-lg-6">
			@component('comps.forms.intro_field')
			@endcomponent
		</div>

		<div class="col-12 mb-2">
			@component('comps.forms.text_field')
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
			@component('comps.forms.image_field')
			@endcomponent
		</div>
	</div>
</form>

@endsection