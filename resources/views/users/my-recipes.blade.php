@extends('layouts.app')

@section('title', trans('includes.my_recipes'))

@section('content')

@component('comps.list-of-recipes', ['recipes' => $recipes])
	@slot('title')
		@lang('includes.my_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.no_recipes_yet')
	@endslot
@endcomponent

@endsection