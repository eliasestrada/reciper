@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('home.home'))

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
@forelse ($recipes->chunk(8) as $chunk1)
    <div class="{{ $loop->iteration == 2 ? 'image-bg' : '' }}">
        <section class="{{ $loop->first || $loop->iteration == 3 ? 'home-section' : 'wrapper' }}">

            @foreach ($chunk1->chunk(4) as $chunk2)
                <div class="row">
                    @foreach ($chunk2 as $recipe)
                        <div class="col s12 m6 l3">
                            <div class="card hoverable">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <a href="/recipes/{{ $recipe->slug }}">
                                        <img class="activator" alt="{{ $recipe->getTitle() }}" src="{{ asset('storage/small/recipes/'.$recipe->image) }}">
                                    </a>
                                </div>
                                <div class="card-content min-h">
                                    <span style="height:75%" class="card-title activator">
                                        {{ $recipe->getTitle() }}
                                    </span>
                                    <div style="height:25%">
                                        <div>
                                            <div class="left">
                                                <btn-favs recipe-id="{{ $recipe->id }}"
                                                    :items="{{ $recipe->favs }}"
                                                    audio-path="{{ asset('storage/audio/fav-effect.wav') }}"
                                                    :user-id="{{ auth()->check() ? user()->id : 'null' }}"
                                                    tooltip="@lang('messages.u_need_to_login')"
                                                >
                                                    <i class="star d-inline-block grey circle mx-2" style="width:10px;height:10px;"></i> 
                                                    ...
                                                </btn-favs>
                                            </div>
                                        </div>
                                        <span class="left card-time">
                                            <i class="fas fa-clock fa-1x z-depth-2 main-light circle red-text ml-5 mr-1"></i>
                                            {{ $recipe->time }} @lang('recipes.min').
                                        </span>
                                        <i class="fas fa-ellipsis-h fa-15x right red-text activator px-1"></i>
                                    </div>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title">{{ $recipe->getTitle() }}</span>
                                    <div><i class="fas fa-times right red-text card-title p-1"></i></div>
                                    <a class="btn-small mt-3" href="/recipes/{{ $recipe->slug }}">
                                        @lang('messages.go')
                                    </a>
                                    <p class="text">{{ $recipe->getIntro() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
    
            <div class="center">
                @if ($loop->first)
                    <a href="/recipes#new" class="btn-large hoverable my-1 waves-effect waves-light" title="@lang('messages.go')">
                        <i class="fas fa-clock left"></i>
                        @lang('home.last_recipes')
                    </a>
                    <a href="/recipes#simple" class="btn-large hoverable my-1 waves-effect waves-light" title="@lang('messages.go')">
                        <i class="fas fa-concierge-bell left"></i>
                        @lang('recipes.simple')
                    </a>
                @elseif ($loop->iteration == 2)
                    <a href="/recipes#breakfast" class="btn-large hoverable my-1 waves-effect waves-light" title="@lang('messages.go')">
                        <i class="fas fa-utensils left"></i>
                        @lang('home.breakfast')
                    </a>
                    <a href="/recipes#lunch" class="btn-large hoverable my-1 waves-effect waves-light" title="@lang('messages.go')">
                        <i class="fas fa-utensils left"></i>
                        @lang('home.lunch')
                    </a>
                    <a href="/recipes#dinner" class="btn-large hoverable my-1 waves-effect waves-light" title="@lang('messages.go')">
                        <i class="fas fa-utensils left"></i>
                        @lang('home.dinner')
                    </a>
                @endif
            </div>
        </section>
    </div>
@empty
    @component('comps.empty')
        @slot('text')
            {{ ($no_recipes ?? trans('users.no_recipes')) }}
        @endslot
    @endcomponent
@endforelse

@endsection