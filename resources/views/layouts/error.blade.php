<!doctype html>
<html lang="{{ _() }}">
<head>
    @include('includes.head')
    <title>@yield('title') - @lang('messages.app_name')</title>
</head>
<body class="{{ request()->cookie('r_dark_theme') ? 'dark-theme' : '' }}">
    <div class="page">
        @yield('content')
    </div>
</body>
</html>