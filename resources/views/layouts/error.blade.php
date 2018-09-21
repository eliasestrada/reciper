<!doctype html>
<html lang="{{ lang() }}">
<head>
    @include('includes.head')
    <title>@yield('title') - @lang('website.name')</title>
</head>
<body>
    <div class="paper page">
        @yield('content')
    </div>
</body>
</html>