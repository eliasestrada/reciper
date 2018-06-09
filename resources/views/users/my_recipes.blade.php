@extends('layouts.app')

@section('title', trans('users.my_recipes'))

@section('content')

@component('comps.list_of_recipes', ['recipes' => $recipes])
	@slot('title')
		@lang('users.my_recipes')
	@endslot
	@slot('no_recipes')
		@lang('users.no_recipes_yet')
	@endslot
@endcomponent

@endsection