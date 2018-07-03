@extends('layouts.app')

@section('title', trans('recipes.recipes'))

@section('content')

<div class="center pt-4"><h1 class="headline">@lang('recipes.recipes')</h1></div>

<div class="px-2 pt-4">
	<recipes go="@lang('recipes.go')">
		@include('includes.preloader')
	</recipes>
</div>

@endsection