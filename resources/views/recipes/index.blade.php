@extends('layouts.app')

@section('title', trans('recipes.recipes'))

@section('content')

<div class="center pt-4"><h1 class="headline">@lang('recipes.recipes')</h1></div>

{{-- Sorting buttons --}}
<div class="px-2 pt-4">
    <sort-buttons
        new-btn="@lang('recipes.new')"
        my-viewes-btn="@lang('recipes.watched')"
        most-liked-btn="@lang('recipes.popular')"
        my-likes-btn="@lang('recipes.loved')">
    </sort-buttons>
    <recipes go="@lang('recipes.go')">
        @include('includes.preloader')
    </recipes>
</div>

@endsection
