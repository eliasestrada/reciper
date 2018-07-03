@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@store') }}" method="post" class="page" enctype="multipart/form-data">

	<div class="row"> @csrf
		<div class="center">
			<h1 class="headline pb-4">@lang('recipes.add_recipe')</h1>
		</div>

		<div class="fixed-action-btn"> {{--  Save button  --}}
			<button type="submit" title="@lang('recipes.save_recipe_desc')" class="waves-effect waves-light btn green z-depth-3 pulse d-flex">
				<i class="large material-icons mr-2">save</i> 
				@lang('recipes.save') 
			</button>
		</div>
	
		<div class="row">
			<div class="col s12 m6 l4"> {{-- Title --}}
				@titleField
				@endtitleField
			</div>
	
			<div class="col s12 m6 l4"> {{-- Time --}}
				@timeField
				@endtimeField
			</div>
	
			<div class="col s12 m6 l4"> {{-- Meal time --}}
				@mealField(['meal' => $meal])
				@endmealField
			</div>
		</div>

		<div class="row">
			<div class="col s12 l6"> {{-- Ingredients --}}
				@ingredientsField
				@endingredientsField
			</div>
	
			<div class="col s12 l6"> {{-- Intro --}}
				@introField
				@endintroField
			</div>
		</div>

		<div class="col s12"> {{-- Text --}}
			@textField
			@endtextField
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
					@include('includes.preloader')
				</categories-field>
			</div>
	
			<div class="col s12 m6"> {{-- Image --}}
				@imageField
				@endimageField
			</div>
		</div>
	</div>
</form>

@endsection

@section('script')
	@include('includes.js.counter')
@endsection