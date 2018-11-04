<!doctype html>
<html lang="{{ LANG() }}">
<head>
    @yield('head')
    @include('includes.head')
    <title>@lang('logs.logs') {{ log_viewer()->version() }}</title>
</head>
<body class="{{ request()->cookie('r_dark_theme') ? 'dark-theme' : '' }}">

    @include('includes.nav.sidenav')
    @include('includes.nav.navbar')

    @hasRole('master')
        <div id="app">
            @yield('content')
        </div>
        @else
        <div class="container py-4">
            <p class="flow-text">@lang('logs.page_is_not_avail')</p>
            @include('includes.buttons.home-btn')
            @include('includes.buttons.help-btn')
        </div>
    @endhasRole

    @include('includes.footer')

    {!! script_timestamp('/js/app.js') !!}

    @include('includes.messages')
</body>
</html>
