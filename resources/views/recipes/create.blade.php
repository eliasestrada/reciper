@extends('layouts.app')

@section('title', trans('recipes.add_recipe'))

@section('content')

{!! Form::open(['action' => 'RecipesController@store', 'method' => 'post', 'class' => 'form', 'enctype' => 'multipart/form-data']) !!}
	<div class="row">

		<div class="col-12">
			<h1 class="headline">@lang('recipes.add_recipe')</h1>
			{{-- Edit button --}}
			<div class="recipe-buttons col-12">
				{{ Form::submit('', ['class' => "edit-recipe-icon icon-save"]) }}
			</div>
		</div>
	
		<div class="col-12 col-md-4">
			{{-- Title --}}
			<div class="form-group">
				<label>@lang('recipes.title')</label>
				{{ Form::text('title', '', ['placeholder' => trans('recipes.title')]) }}
			</div>
		</div>
		<div class="col-12 col-md-4">
			{{-- Category --}}
			<div class="form-group simple-group">
				<label>@lang('recipes.category')</label>
				<select name="category_id">
					@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-12 col-md-4">
			{{-- Time --}}
			<div class="form-group simple-group">
				{{ Form::label('time', trans('recipes.time_description')) }}
				{{ Form::number('time', '0') }}
			</div>
		</div>

		<div class="col-12 col-lg-6">
			{{-- Ingredients --}}
			<div class="form-group">
				<label>@lang('recipes.ingredients')</label>
				{{ Form::textarea('ingredients', '', ['placeholder' => trans('recipes.ingredients_description')]) }}
			</div>
		</div>
		<div class="col-12 col-lg-6">
			{{-- Advice --}}
			<div class="form-group">
				<label>@lang('recipes.intro')</label>
				{{ Form::textarea('intro', '', ['placeholder' => trans('recipes.short_intro')]) }}
			</div>
		</div>

		<div class="col-12">
			{{-- Text --}}
			<div class="form-group">
				<label>@lang('recipes.text_of_recipe')</label>
				{{ Form::textarea('text', '', ['placeholder' => trans('recipes.text_description')]) }}
			</div>
		</div>

		{{-- Image --}}
		<div class="form-group simple-group text-center col-12">
			<div class="row">
				<div class="col-md-4 offset-md-2">
					{{ Form::label('src-image', trans('recipes.select_file'), ['class' => 'image-label']) }}
					{{ Form::file('image', ['class' => "d-none", "id" => "src-image"]) }}
				</div>
				<div class="col-md-4">
					<section class="preview-image">
						<img src="{{ asset('storage/images/default.jpg') }}" alt="@lang('recipes.image')" id="target-image">
					</section>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}

@endsection