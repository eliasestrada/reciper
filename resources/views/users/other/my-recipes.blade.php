@extends('layouts.app')

@section('title', trans('includes.my_recipes'))

@section('content')

{{-- Add recipe button --}}
@component('comps.btns.fixed-btn')
	@slot('icon') add @endslot
	@slot('color') green @endslot
	@slot('link') /recipes/create @endslot
	@slot('tip') @lang('includes.new_recipe') @endslot
@endcomponent

@listOfRecipes(['recipes' => $recipes])
	@slot('title')
		@lang('includes.my_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.no_recipes_yet')
		@include('includes.buttons.btn', [
			'title' => trans('includes.add_recipe'),
			'icon' => 'add',
			'link' => '/recipes/create'
		])
	@endslot
@endlistOfRecipes

@endsection