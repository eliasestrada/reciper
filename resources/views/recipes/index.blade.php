@extends(setLayout())

@section('title', trans('recipes.recipes'))

@section('content')

<div class="page" id="recipes-page">
    <div class="center"><h1 class="header">@lang('recipes.recipes')</h1></div>

    <div class="my-3" v-cloak>
        <sort-buttons
            new-btn="@lang('recipes.last')"
            my-views-btn="@lang('recipes.watched')"
            most-liked-btn="@lang('recipes.popular')"
            simple-btn="@lang('recipes.simple')"
            breakfast-btn="@lang('home.breakfast')"
            lunch-btn="@lang('home.lunch')"
            dinner-btn="@lang('home.dinner')">
        </sort-buttons>
    </div>
    @isset($favs)
        <recipes
            go="@lang('messages.go')"
            :favs="{{ $favs }}"
            audio-path="{{ asset('storage/audio/fav-effect.wav') }}"
            :user-id="{{ auth()->check() ? user()->id : 'null' }}"
            tooltip="@lang('messages.u_need_to_login')"
            mins="@lang('recipes.min')">
            @include('includes.preloader')
        </recipes>
    @endisset
</div>

@endsection
