<form action="{{ action('RecipesController@store') }}" method="post" class="page" enctype="multipart/form-data">

	@csrf

	<div class="row"> 
		<div class="center">
			<h1 class="headline pb-4">@lang('recipes.add_recipe')</h1>
		</div>

		{{--  Save button  --}}
		<div class="center pb-4">
			<button type="submit" class="btn green">
				<i class="material-icons left">save</i>
				@lang('tips.save')
			</button>
		</div>
	
		<div class="row">
			{{-- Title --}}
			<div class="col s12 m6 l4">
				<div class="input-field">
					<input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('validation.recipe_title_max') }}">
					<label for="title">@lang('recipes.title')</label>
				</div>
			</div>
	
			{{-- Time --}}
			<div class="col s12 m6 l4">
				<div class="input-field">
					<input type="number" name="time" id="time" value="{{ ($time ?? 0) }}">
					<label for="time">@lang('recipes.time_description')</label>
				</div>
			</div>
	
			{{-- Meal --}}
			<div class="col s12 m6 l4">
				<label for="meal">@lang('recipes.meal_description')</label>
				<select name="meal" id="meal" class="browser-default">
					@foreach ($meal as $m)
						<option value="{{ $m->id }}" {{ set_as_selected_if_equal($m->id, (old('meal') ?? '')) }}>
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
					<textarea name="ingredients" id="ingredients" class="materialize-textarea counter" data-length="{{ config('validation.recipe_ingredients_max') }}">{{ old('ingredients') }}</textarea>
				
					<label for="ingredients">
						@lang('recipes.ingredients') 
						@include('includes.tip', ['tip' => trans('recipes.ingredients_desc')])
					</label>
				</div>
			</div>
	
			{{-- Intro --}}
			<div class="col s12 l6">
				<div class="input-field">
					<textarea name="intro" id="intro" class="materialize-textarea counter" data-length="{{ config('validation.recipe_intro_max') }}">{{ old('intro') }}</textarea>

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
				<textarea name="text" id="text" class="materialize-textarea counter" data-length="{{ config('validation.recipe_text_max') }}">{{ old('text') }}</textarea>

				<label for="text">
					@lang('recipes.text_of_recipe') 
					@include('includes.tip', ['tip' => trans('recipes.text_description')])
				</label>
			</div>
		</div>

		<div class="row">
			{{-- Categories --}}
			<div class="col s12 m6">
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
						<img src="{{ asset('storage/images/default.jpg') }}" alt="@lang('recipes.image')" id="target-image">
					</section>
				</div>
			</div>
		</div>
	</div>
</form>