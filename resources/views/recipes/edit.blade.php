@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="form" enctype="multipart/form-data" id="form-update-recipe">

	@method('put')
	@csrf

	<div class="row">
		<div class="col s12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>

			<div class="fixed-action-btn">
				<a href="#" class="btn-floating main btn-large pulse z-depth-3"><i class="large material-icons">more_vert</i></a>
				<ul>
					<li> {{--  Delete button  --}}
						<delete-recipe-btn
							recipe-id="{{ $recipe->id }}"
							deleted-fail="{{ trans('recipes.deleted_fail') }}"
							deleting="{{ trans('recipes.deleting') }}"
							confirm="{{ trans('recipes.are_you_sure_to_delete') }}">
						</delete-recipe-btn>
					</li>
					<li> {{--  Publish button  --}}
						<a href="#" class="btn-floating green btn-large" title="@lang('recipes.press_to_publish')" id="publish-btn">
							<i class="large material-icons">send</i>
						</a>
						<input type="checkbox" name="ready" value="1" class="d-none" id="ready-checkbox">
					</li>
					<li> {{--  View button  --}}
						<a href="/recipes/{{ $recipe->id }}" class="btn-floating green btn-large" title="@lang('recipes.view_recipe')">
							<i class="large material-icons">remove_red_eye</i>
						</a>
					</li>
					<li> {{--  Save button  --}}
						<button type="submit" id="submit-save-recipe" title="@lang('recipes.save_recipe')" class="btn-floating green btn-large">
							<i class="large material-icons">save</i>
						</button>
					</li>
				</ul>
			</div>
		</div>

		{{-- Title --}}
		<div class="col s12 m4">
			@component('comps.forms.title_field')
				@slot('title')
					{{ $recipe->getTitle() }}
				@endslot
			@endcomponent
		</div>

		{{-- Time --}}
		<div class="col s12 m4">
			@component('comps.forms.time_field')
				@slot('time')
					{{ $recipe->time }}
				@endslot
			@endcomponent
		</div>

		{{-- Meal time --}}
		<div class="col s12 m6 m4">
			@component('comps.forms.meal_field', ['meal' => $meal])
				@slot('meal_id')
					{{ $recipe->meal->id }}
				@endslot
			@endcomponent
		</div>

		{{-- Ingredients --}}
		<div class="col s12 l6">
			@component('comps.forms.ingredients_field')
				@slot('ingredients')
					{{ $recipe->getIngredients() }}
				@endslot
			@endcomponent
		</div>

		{{-- Advice --}}
		<div class="col s12 l6">
			@component('comps.forms.intro_field')
				@slot('intro')
					{{ $recipe->getIntro() }}
				@endslot
			@endcomponent
		</div>

		{{-- Text --}}
		<div class="col s12 mb-2">
			@component('comps.forms.text_field')
				@slot('text')
					{{ $recipe->getText() }}
				@endslot
			@endcomponent
		</div>

		<div class="form-group col s12 m6" style="border-bottom:solid 1px lightgray;">
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
		<div class="col s12 m6">
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

@section('script')
	@include('includes.js.floating-btn')
@endsection