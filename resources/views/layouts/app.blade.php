<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - {{ config('app.name') }}</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')

	@include('includes.user-sidebar')

	<div class="wrapper">
		@include('includes.messages')
		@yield('content')
	</div>

    @include('includes.footer')

    {{ Visitor::log() }}

	<!-- Javascript -->
	{!! scriptTimestamp('/js/app.js') !!}
	@yield('script')
</body>
</html>