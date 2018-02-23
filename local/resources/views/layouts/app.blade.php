<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.navbar')
    <main id="main">
        <div class="wrapper">
            @include('includes.messages')
            @yield('content')
        </div>
    </main>
    @include('includes.footer')
    <!-- Javascript -->
    <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
</body>
</html>