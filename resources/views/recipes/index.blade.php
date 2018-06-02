@extends('layouts.app')

@section('title', trans('recipes.recipes'))

@section('content')

<h1 class="headline">@lang('recipes.recipes')</h1>

<div class="recipes">
	<recipes></recipes>
</div>

@endsection