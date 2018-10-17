@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('recipes.recipes'))

@section('content')

<div class="page">
    <div class="center"><h1 class="header">@lang('recipes.recipes')</h1></div>

    <div class="my-3" v-cloak>
        <sort-buttons
            new-btn="@lang('recipes.last')"
            my-viewes-btn="@lang('recipes.watched')"
            most-liked-btn="@lang('recipes.popular')"
            simple-btn="@lang('recipes.simple')"
            breakfast-btn="@lang('home.breakfast')"
            lunch-btn="@lang('home.lunch')"
            dinner-btn="@lang('home.dinner')" inline-template>
            <div>
                <a :href="'/recipes#' + btn.link" v-for="btn in btns" :key="btn.link" :class="{ 'active': btn.isActive }" class="btn btn-sort main-text">
                    <i class="fas red-text left" :class="btn.icon"></i>
                    <span v-text="btn.title"></span>
                </a>
            </div>
        </sort-buttons>
    </div>
    <recipes
        go="@lang('messages.go')"
        :favs="{{ $favs }}"
        :user-id="{{ auth()->check() ? user()->id : 'null' }}"
        mins="@lang('recipes.min')">
        @include('includes.preloader')
    </recipes>
</div>

@endsection
