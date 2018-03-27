<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - Delicious Food</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')

	@include('includes.messages-public')

    @yield('content')

    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
	<script type="text/javascript" src="{{ URL::asset('js/main.js') }}?ver={{ env('APP_VER') }}"></script>
</body>
</html>