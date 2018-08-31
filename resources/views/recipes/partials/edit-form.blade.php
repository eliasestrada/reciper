<form action="{{ action('RecipesController@update', ['recipe' => $recipe->id]) }}" method="post" class="page" enctype="multipart/form-data" id="form-update-recipe">

	@method('put')
	@csrf

	<div class="row">
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
	
		<div class="row">
			{{-- Title --}}
			<div class="col s12 m6 l4">
				<div class="input-field">
					<input type="text" name="title" id="title" value="{{ $recipe->getTitle() }}" class="counter" data-length="{{ config('validation.recipe_title_max') }}">
					<label for="title">@lang('recipes.title')</label>
				</div>
			</div>
	
			{{-- Time --}}
			<div class="col s12 m6 l4">
				<div class="input-field">
					<input type="number" name="time" id="time" value="{{ $recipe->time }}">
					<label for="time">@lang('recipes.time_description')</label>
				</div>
			</div>
	
			{{-- Meal --}}
			<div class="col s12 m6 l4">
				<label for="meal">@lang('recipes.meal_description')</label>
				<select name="meal" id="meal" class="browser-default">
					@foreach ($meal as $m)
						<option value="{{ $m->id }}" {{ selectedIfEqual($m->id, ($recipe->meal->id ?? '')) }}>
							{{ title_case($m->getName()) }}
						</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="row">
			{{-- Ingredients --}}
			<div class="col s12 l6">
				<div class="input-field">
					<textarea name="ingredients" id="ingredients" class="materialize-textarea counter" data-length="{{ config('validation.recipe_ingredients_max') }}">{{ $recipe->getIngredients() }}</textarea>
				
					<label for="ingredients">
						@lang('recipes.ingredients') 
						@include('includes.tip', ['tip' => trans('recipes.ingredients_desc')])
					</label>
				</div>
			</div>
	
			{{-- Intro --}}
			<div class="col s12 l6">
				<div class="input-field">
					<textarea name="intro" id="intro" class="materialize-textarea counter" data-length="{{ config('validation.recipe_intro_max') }}">{{ $recipe->getIntro() }}</textarea>

					<label for="intro">
						@lang('recipes.short_intro') 
						@include('includes.tip', ['tip' => trans('recipes.text_description')])
					</label>
				</div>
			</div>
		</div>

		{{-- Text --}}
		<div class="col s12">
			<div class="input-field">
				<textarea name="text" id="text" class="materialize-textarea counter" data-length="{{ config('validation.recipe_text_max') }}">{{ $recipe->getText() }}</textarea>

				<label for="text">
					@lang('recipes.text_of_recipe') 
					@include('includes.tip', ['tip' => trans('recipes.text_description')])
				</label>
			</div>
		</div>

		{{-- Categories --}}
		<div class="row">
			<div class="col s12 m6">
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
	
			{{-- Image --}}
			<div class="col s12 m6">
				<div class="center pb-5">
					<h5 class="col s12 mb-2">@lang('recipes.image')</h5>

					<div class="file-field input-field">
						<div class="btn">
							<span>@lang('recipes.select_file')</span>
							<input type="file" name="image" id="src-image" style="overflow:hidden">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>

					<section class="preview-image">
						<img src="{{ asset("storage/images/small/$recipe->image") }}" alt="{{ $recipe->title }}" id="target-image">
					</section>
				</div>
			</div>
		</div>
	</div>
</form>