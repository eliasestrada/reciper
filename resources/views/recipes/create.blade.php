@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@store') }}" method="post" class="pt-4" enctype="multipart/form-data">

	<div class="row"> @csrf
		<div class="center-align">
			<h1 class="headline mb-3">@lang('recipes.add_recipe')</h1>
		</div>

		<div class="fixed-action-btn"> {{--  Save button  --}}
			<button type="submit" title="@lang('recipes.save_recipe_desc')" class="waves-effect waves-light btn green z-depth-3 pulse d-flex">
				<i class="large material-icons mr-2">save</i> 
				@lang('recipes.save') 
			</button>
		</div>
	
		<div class="row">
			<div class="col s12 m6 l4"> {{-- Title --}}
				@component('comps.forms.title_field')
				@endcomponent
			</div>
	
			<div class="col s12 m6 l4"> {{-- Time --}}
				@component('comps.forms.time_field')
				@endcomponent
			</div>
	
			<div class="col s12 m6 l4"> {{-- Meal time --}}
				@component('comps.forms.meal_field', ['meal' => $meal])
				@endcomponent
			</div>
		</div>

		<div class="row">
			<div class="col s12 l6"> {{-- Ingredients --}}
				@component('comps.forms.ingredients_field')
				@endcomponent
			</div>
	
			<div class="col s12 l6"> {{-- Intro --}}
				@component('comps.forms.intro_field')
				@endcomponent
			</div>
		</div>

		<div class="col s12"> {{-- Text --}}
			@component('comps.forms.text_field')
			@endcomponent
		</div>

		<div class="row">
			<div class="col s12 m6"> {{-- Categories --}}
				<categories-field
					locale="{{ locale() }}"
					label="@lang('recipes.category')"
					select="@lang('form.select')"
					categories-title="@lang('recipes.categories_title')"
					deleting="@lang('form.deleting')"
					add="@lang('form.add')">
				</categories-field>
			</div>
	
			<div class="col s12 m6"> {{-- Image --}}
				@component('comps.forms.image_field')
				@endcomponent
			</div>
		</div>
	</div>
</form>

@endsection

@section('script')
	@include('includes.js.counter')
@endsection