@extends('layouts.app')

@section('title', trans('recipes.recipes'))

@section('content')

<div class="page">
    <div class="center"><h1 class="headline">@lang('recipes.recipes')</h1></div>

    <div class="my-3">
        <sort-buttons
            new-btn="@lang('recipes.new')"
            my-viewes-btn="@lang('recipes.watched')"
            most-liked-btn="@lang('recipes.popular')"
            my-likes-btn="@lang('recipes.loved')"
            simple-btn="@lang('recipes.simple')"
            breakfast-btn="@lang('home.breakfast')"
            lunch-btn="@lang('home.lunch')"
            dinner-btn="@lang('home.dinner')"
            >
        </sort-buttons>
    </div>
    <recipes go="@lang('recipes.go')">
        @include('includes.preloader')
    </recipes>
</div>

@endsection
