@extends('layouts.app')

@section('title', trans('pages.home'))

@section('home-header')
    <header class="home-header">
        <div class="header-content">

            <h1>{{ config('app.name') }}</h1>
            <div class="home-meal">
                @lang('home.what_u_like')
                <br>
                <a href="/recipes#breakfast">{{ title_case(trans('home.breakfast')) }}</a>, 
                <a href="/recipes#lunch">@lang('home.lunch')</a>
                @lang('home.or') 
                <a href="/recipes#dinner">@lang('home.dinner')</a>?
                <br>
                @lang('home.or_maybe') 
                <a href="/recipes#simple">@lang('home.sth_new')</a>
            </div>

            {{--  Form  --}}
            <form action="{{ action('PagesController@search') }}" method="get" class="header-search">
                <div class="position-relative">
                    <div class="home-search" id="home-search-form">
                        <input type="search" name="for" id="header-search-input" placeholder="@lang('pages.search_details')">
                    </div>
                    <button type="submit" class="home-button" id="home-search-btn">
                        <i class="material-icons">search</i>
                    </button>
                </div>
            </form>
        </div>
    </header>
@endsection

@section('content')

<section class="home-section position-relative">
    @isset($title_intro)
        <div class="center">
            <h2 class="headline">{{ ($title_intro->getTitle() ?? '') }}</h2>
        </div>
        <p>{{ ($title_intro->getText() ?? '') }}</p>
    @endisset

    @hasRole('admin')
        {{--  Настройки Интро  --}}
        <a class="magic-btn" title="@lang('home.edit_intro')" id="btn-for-intro">
            <i class="material-icons">edit</i>
        </a>

        @magicForm
            @slot('id')
                intro-form
            @endslot
            @slot('action')
                TitleController@intro
            @endslot
            @slot('title')
                {{ $title_intro->getTitle() }}
            @endslot
            @slot('text')
                {{ $title_intro->getText() }}
            @endslot
            @slot('holder_title')
                @lang('home.intro_title')
            @endslot
            @slot('slug_title')
                intro_title
            @endslot
            @slot('holder_text')
                @lang('home.intro_text')
            @endslot
            @slot('slug_text')
                intro_text
            @endslot
        @endmagicForm
    @endhasRole
</section>

{{--  Cards  --}}
<section class="home-section">
    @if (isset($random_recipes) && !empty($random_recipes))
        @foreach ($random_recipes->chunk(4) as $chunk)
            <div class="row">
                @foreach ($chunk as $random)
                    <div class="col s12 m6 l3">
                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                                <a href="/recipes/{{ $random->id }}">
                                    <img class="activator" alt="{{ $random->getTitle() }}" src="{{ asset('storage/images/small/'.$random->image) }}">
                                </a>
                            </div>
                            <div class="card-content min-h">
                                <span style="height:75%" class="card-title activator">
                                    {{ $random->getTitle() }}
                                </span>
                                <div style="height:25%">
                                    <i class="material-icons right small red-text activator">more_horiz</i>
                                </div>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title">{{ $random->getTitle() }}</span>
                                <div><i class="material-icons right red-text card-title">close</i></div>
                                <a class="btn-small mt-3" href="/recipes/{{ $random->id }}">
                                    @lang('recipes.go')
                                </a>
                                <p>{{ $random->getIntro() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</section>

@endsection