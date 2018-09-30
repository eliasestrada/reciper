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

    @foreach ($random_recipes->chunk(4) as $chunk)
        <div class="row">
            @foreach ($chunk as $random)
                <div class="col s12 m6 l3">
                    <div class="card hoverable">
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
                                <i class="fas fa-ellipsis-h fa-15x right red-text activator"></i>
                            </div>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title">{{ $random->getTitle() }}</span>
                            <div><i class="fas fa-times right red-text card-title"></i></div>
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

        @foreach ($last_liked->chunk(4) as $chunk)
            <div class="row">
                @foreach ($chunk as $liked)
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-image waves-effect waves-block waves-light">
                                <a href="/recipes/{{ $liked->recipe_id }}">
                                    <img class="activator" alt="{{ $liked->getTitle() }}" src="{{ asset('storage/images/small/'.$liked->image) }}">
                                </a>
                            </div>
                            <div class="card-content min-h">
                                <span style="height:75%" class="card-title activator">
                                    {{ $liked->getTitle() }}
                                </span>
                                <div style="height:25%">
                                    <i class="fas fa-ellipsis-h fa-15x right red-text activator"></i>
                                </div>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title">{{ $liked->getTitle() }}</span>
                                <div><i class="fas fa-times right red-text card-title"></i></div>
                                <a class="btn-small mt-3" href="/recipes/{{ $liked->id }}">
                                    @lang('recipes.go')
                                </a>
                                <p>{{ $liked->getIntro() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

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