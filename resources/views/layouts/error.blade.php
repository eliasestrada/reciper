<!doctype html>
<html lang="{{ LANG() }}">
<head>
    @include('includes.head')
    <title>@yield('title') - @lang('messages.app_name')</title>
</head>
<body>
    <div class="page">
        @yield('content')
    </div>
</body>
</html>