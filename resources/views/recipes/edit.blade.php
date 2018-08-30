@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="page" enctype="multipart/form-data" id="form-update-recipe">

	<div class="row"> @method('put') @csrf
		<div class="col s12">
			<div class="center">
				<h1 class="headline pb-4">@lang('recipes.add_recipe')</h1>
			</div>

			<div class="center pb-4">
				{{--  View button  --}}
				<a href="/recipes/{{ $recipe->id }}" class="btn green tooltipped" data-tooltip="@lang('tips.view_recipe')" data-position="top">
					<i class="material-icons">remove_red_eye</i>
				</a>

				{{--  Save button  --}}
				<button type="submit" id="submit-save-recipe" data-tooltip="@lang('tips.save_recipe')" data-position="top" class="btn green tooltipped">
					<i class="material-icons">save</i>
				</button>

				{{--  Delete button  --}}
				<delete-recipe-btn
					recipe-id="{{ $recipe->id }}"
					deleted-fail="{{ trans('recipes.deleted_fail') }}"
					delete-recipe-tip="{{ trans('tips.delete_recipe') }}"
					confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
				</delete-recipe-btn>

				{{--  Publish button  --}}
				<a href="#" class="btn green tooltipped" id="publish-btn" data-tooltip="@lang('tips.publish_recipe')" data-position="top">
					<i class="large material-icons">send</i>
				</a>
				<input type="checkbox" name="ready" value="1" class="d-none" id="ready-checkbox">
			</div>
		</div>

		<div class="row">
			<div class="col s12 m4"> {{-- Title --}}
				@titleField
					@slot('title')
						{{ $recipe->getTitle() }}
					@endslot
				@endtitleField
			</div>
	
			<div class="col s12 m4"> {{-- Time --}}
				@timeField
					@slot('time')
						{{ $recipe->time }}
					@endslot
				@endtimeField
			</div>
	
			<div class="col s12 m4"> {{-- Meal time --}}
				@mealField(['meal' => $meal])
					@slot('meal_id')
						{{ $recipe->meal->id }}
					@endslot
				@endmealField
			</div>
		</div>

		<div class="row">
			<div class="col s12 l6"> {{-- Ingredients --}}
				@ingredientsField
					@slot('ingredients')
						{{ $recipe->getIngredients() }}
					@endslot
				@endingredientsField
			</div>
	
			<div class="col s12 l6"> {{-- Advice --}}
				@introField
					@slot('intro')
						{{ $recipe->getIntro() }}
					@endslot
				@endintroField
			</div>
		</div>

		<div class="col s12 mb-2"> {{-- Text --}}
			@textField
				@slot('text')
					{{ $recipe->getText() }}
				@endslot
			@endtextField
		</div>

		<div class="row">
			<div class="col s12 m6"> {{-- Categories --}}
				<categories-field
					locale="{{ lang() }}"
					:recipe-categories="{{ json_encode($recipe->categories->toArray()) }}"
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
					@slot('image')
						{{ 'small/' . $recipe->image }}
					@endslot
					@slot('alt')
						{{ $recipe->title }}
					@endslot
				@endimageField
			</div>
		</div>
	</div>
</form>

@endsection

@section('script')
	@include('includes.js.counter')
@endsection