@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

<form action="{{ action('RecipesController@store') }}" method="post" class="page" enctype="multipart/form-data">

	<div class="row"> @csrf
		<div class="center">
			<h1 class="headline pb-4">@lang('recipes.add_recipe')</h1>
		</div>

		<div class="center pb-4"> {{--  Save button  --}}
			<button type="submit" class="btn green">
				<i class="material-icons left">save</i>
				@lang('recipes.save')
			</button>
		</div>
	
		<div class="row">
			<div class="col s12 m6 l4"> {{-- Title --}}
				@titleField
					@slot('title')
						{{ old('title') }}
					@endslot
				@endtitleField
			</div>
	
			<div class="col s12 m6 l4"> {{-- Time --}}
				@timeField
				@endtimeField
			</div>
	
			<div class="col s12 m6 l4"> {{-- Meal time --}}
				@mealField(['meal' => $meal])
					@slot('meal_id')
						{{ old('meal') }}
					@endslot
				@endmealField
			</div>
		</div>

		<div class="row">
			<div class="col s12 l6"> {{-- Ingredients --}}
				@ingredientsField
					@slot('ingredients')
						{{ old('ingredients') }}
					@endslot
				@endingredientsField
			</div>
	
			<div class="col s12 l6"> {{-- Intro --}}
				@introField
					@slot('intro')
						{{ old('intro') }}
					@endslot
				@endintroField
			</div>
		</div>

		<div class="col s12"> {{-- Text --}}
			@textField
				@slot('text')
					{{ old('text') }}
				@endslot
			@endtextField
		</div>

		<div class="row">
			<div class="col s12 m6"> {{-- Categories --}}
				<categories-field
					locale="{{ lang() }}"
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