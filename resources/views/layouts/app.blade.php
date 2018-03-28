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
	{!! scriptTimestamp('/js/main.js') !!}
	@yield('script')
</body>
</html>