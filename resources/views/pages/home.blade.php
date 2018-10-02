@extends('layouts.app')

@section('title', trans('pages.home'))

@section('home-header')

<header class="home-header">
    <div class="header-content">

        <h1>@lang('messages.app_name')</h1>
        <div class="home-meal">
            <div><a href="/recipes#simple">@lang('home.show_simple_recipes')</a></div>
            <div>
                <a href="/recipes#breakfast">{{ title_case(trans('home.breakfast')) }}</a>, 
                <a href="/recipes#lunch">@lang('home.lunch')</a>
                @lang('home.or') 
                <a href="/recipes#dinner">@lang('home.dinner')</a>
            </div>
            <div>
                <a href="#add-recipe-modal" class="modal-trigger main-dark px-3">@lang('home.add_your_recipe')</a>
            </div>
        </div>

        {{--  Form  --}}
        <form action="{{ action('PagesController@search') }}" method="get" class="header-search">
            <div class="position-relative">
                <div class="home-search" id="home-search-form">
                    <input type="search" name="for" id="header-search-input" placeholder="@lang('pages.search_details')">
                </div>
                <button type="submit" class="home-button" id="home-search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</header>

@endsection

@section('content')

{{--  Cards  --}}
<section class="home-section">
    <div class="center"><h4 class="section-headline mt-3 mb-4">@lang('home.random_choice')</h4></div>

    @component('comps.card', ['recipes' => $random_recipes]) @endcomponent

    <div class="center">
        <a href="/recipes#new" class="btn-large hoverable my-1 waves-effect waves-light">
            <i class="fas fa-clock left"></i>
            @lang('home.last_recipes')
        </a>
        <a href="/recipes#simple" class="btn-large hoverable my-1 waves-effect waves-light">
            <i class="fas fa-concierge-bell left"></i>
            @lang('recipes.simple')
        </a>
    </div>
</section>

@endsection

@section('home-last-liked')

<div class="main-dark home-bg-section">
    <section class="p-4">
        <div class="center pb-3"><h2 class="section-headline white-text">@lang('home.last_liked')</h2></div>

        @component('comps.card', ['recipes' => $last_liked]) @endcomponent

        <div class="center">
            <a href="/recipes#breakfast" class="btn-large hoverable my-1 waves-effect waves-light">
                <i class="fas fa-utensils left"></i>
                @lang('home.breakfast')
            </a>
            <a href="/recipes#lunch" class="btn-large hoverable my-1 waves-effect waves-light">
                <i class="fas fa-utensils left"></i>
                @lang('home.lunch')
            </a>
            <a href="/recipes#dinner" class="btn-large hoverable my-1 waves-effect waves-light">
                <i class="fas fa-utensils left"></i>
                @lang('home.dinner')
            </a>
        </div>
    </section>
</div>

@endsection