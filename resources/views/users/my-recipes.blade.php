@extends('layouts.app')

@section('title', trans('includes.my_recipes'))

@section('content')

<div class="fixed-action-btn">
	<a href="/recipes/create" title="@lang('includes.new_recipe')" class="waves-effect waves-light btn green z-depth-3 pulse d-flex">
		<i class="large material-icons mr-2">add</i> 
		@lang('includes.new_recipe')
	</a>
</div>

@component('comps.list-of-recipes', ['recipes' => $recipes])
	@slot('title')
		@lang('includes.my_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.no_recipes_yet')
	@endslot
@endcomponent

@endsection