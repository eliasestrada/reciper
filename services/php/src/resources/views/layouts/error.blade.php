<!doctype html>
<html lang="{{ _() }}">
<head>
    @include('includes.head')
    <title>@yield('title') - @lang('messages.app_name')</title>
</head>

<body class="{{ dark_theme() }}">
    <div class="page">
        @yield('content')
    </div>
</body>
</html>