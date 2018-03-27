<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
		<title>@yield('title') - {{ config('app.name') }}</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')

	@include('includes.messages-public')

    @yield('content')

    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
	<script type="text/javascript" src="{{ URL::asset('js/main.js') }}?ver={{ config('app.version') }}"></script>
</body>
</html>