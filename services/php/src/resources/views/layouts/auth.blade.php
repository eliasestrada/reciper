<!doctype html>
<html lang="{{ _() }}">
<head>
    @yield('head')
    @include('includes.head')
    <title>@yield('title') - @lang('messages.app_name')</title>
</head>

<body class="{{ dark_theme() }}">
    @include('includes.nav.sidenav')
    @include('includes.nav.navbar')

    @yield('home-header')

    <div id="app">
        @if (user()->isActive())
            @yield('content')
        @else
            <div class="page pt-4 center">
                <img src="{{ asset('storage/big/users/not_active.jpg') }}"
                    class="profile-image frames z-depth-1 hoverable"
                    alt="{{ user()->getName() }}"
                />

                <h5 class="mt-4 main-text">@lang('users.we_missed_you')</h5>

                <p class="header">
                    @lang('users.activate_account_desc', [
                        'days' => 30 - (date('j') - user()->updated_at->format('j'))
                    ])
                </p>

                <form action="{{ action('UserController@store') }}" method="post">
                    @csrf
                    <button type="submit"
                        class="btn mt-3 green hoverable waves-effect waves-green z-depth-2 confirm"
                        data-confirm="@lang('users.are_you_sure_to_recover')"
                    >
                        <i class="fas fa-unlock-alt left"></i>
                        @lang('users.recover')
                    </button>
                </form>

            </div>
        @endif
    </div>

    <!-- add-recipe-modal structure -->
    <div id="add-recipe-modal" class="modal">
        <div class="modal-content reset">
            <form action="{{ action('RecipeController@store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="center">
                    <p class="mb-0 flow-text">@lang('recipes.name_for_recipe')</p>
                </div>

                {{-- Title --}}
                <div class="input-field">
                    <input type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        class="counter"
                        data-length="{{ config('valid.recipes.title.max') }}"
                        minlength="5"
                        required
                    />
                    <label for="title">@lang('recipes.title')</label>
                    @include('includes.input-error', ['field' => 'title'])
                </div>

                {{--  Save button  --}}
                <div class="center pb-2">
                    <button type="submit" class="btn waves-effect waves-light">
                        <i class="fas fa-angle-right right"></i>
                        @lang('recipes.next')
                    </button>
                </div>
            </form>
        </div>
    </div>

    <audio id="click-audio" class="hidden">
        <source src="{{ asset('storage/audio/click-audio.wav') }}" type="audio/wav">
    </audio>

    @include('includes.footer')

    {!! script_timestamp('/js/app.js') !!}

    @yield('script')
    @include('includes.messages')
</body>
</html>