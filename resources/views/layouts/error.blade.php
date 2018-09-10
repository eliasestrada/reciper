<!doctype html>
<html lang="{{ lang() }}">
<head>
    @include('includes.head')
    <title>@yield('title') - @lang('website.name')</title>
</head>
<body>
    <div style="background:#eee;">
        @yield('content')
    </div>
</body>
</html>