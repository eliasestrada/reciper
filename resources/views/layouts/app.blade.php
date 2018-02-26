<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    @include('includes.head')

</head>
<body>
    @include('includes.navbar')
    <main id="main">

        @include('includes.messages')

        @yield('content')

    </main>
    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
    <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
</body>
</html>