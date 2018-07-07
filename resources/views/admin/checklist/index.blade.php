@extends('layouts.app')

@section('title', trans('admin.checklist'))

@section('content')

@admin
	@listOfRecipes(['recipes' => $unapproved])
		@slot('title')
			@lang('admin.checklist')
		@endslot
		@slot('no_recipes')
			@lang('admin.no_unapproved')
		@endslot
	@endlistOfRecipes
@endadmin

@endsection