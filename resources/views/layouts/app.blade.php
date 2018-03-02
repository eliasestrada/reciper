<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - Delicious Food</title>
</head>
<body>
    @include('includes.navbar')
    <main id="main">

        @include('includes.messages')

        @yield('body')

    </main>
    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
    <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
</body>
</html>