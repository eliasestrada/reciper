<!doctype html>
<html lang="{{ lang() }}">
<head>
    @yield('head')
    @include('includes.head')
    <title>@yield('title') - @lang('messages.app_name')</title>
</head>
<body>

    @include('includes.nav.sidenav')
    @include('includes.nav.navbar')

    @yield('home-header')

    <div id="app" class="wrapper">
        @yield('content')
    </div>

    @yield('home-last-liked')

    <!-- add-recipe-modal structure -->
    <div id="add-recipe-modal" class="modal">
        <div class="modal-content reset">
            @auth
                <form action="{{ action('RecipesController@store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="center">
                        <p class="mb-0 flow-text main-text">@lang('recipes.name_for_recipe')</p>
                    </div>

                    {{-- Title --}}
                    <div class="input-field">
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="counter" data-length="{{ config('validation.recipes.title.max') }}" minlength="5" required>
                        <label for="title">@lang('recipes.title')</label>
                    </div>

                    {{--  Save button  --}}
                    <div class="center pb-2">
                        <button type="submit" class="btn waves-effect waves-light">
                            <i class="fas fa-angle-right right"></i>
                            @lang('recipes.next')
                        </button>
                    </div>
                </form>
            @else
                <div class="center row">
                    <span class="col s12 m5">
                        <img src="{{ asset('storage/other/logo.svg') }}" alt="logo" height="150">
                    </span>
                    <p class="pt-1 col s12 m7 left-align">{!! trans('messages.login_to_add_recipe') !!}</p>
                    <div class="col s12">
                        @include('includes.buttons.btn', ['title' => trans('forms.login'), 'link' => '/login'])
                        @include('includes.buttons.btn', ['title' => trans('forms.register'), 'link' => '/register'])
                    </div>
                </div>
            @endauth
        </div>
        <audio id="favs-effect" src="/storage/audio/favs-effect.mp3" class="hide" type="audio/mpeg"></audio>
    </div>

    @include('includes.footer')

    {!! script_timestamp('/js/app.js') !!}

    @yield('script')
    @include('includes.messages')
</body>
</html>