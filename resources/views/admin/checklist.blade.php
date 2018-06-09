@extends('layouts.app')

@section('title', trans('admin.checklist'))

@section('content')

@admin
	@component('comps.list_of_recipes', ['recipes' => $unapproved])
		@slot('title')
			@lang('admin.checklist')
		@endslot
		@slot('no_recipes')
			@lang('admin.no_unapproved')
		@endslot
	@endcomponent
@endadmin

@endsection