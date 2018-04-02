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

	@auth
		<div class="wrapper wrapper-user">
			@include('includes.messages')
			@yield('content')
		</div>
	@else
		@include('includes.messages-public')
		<div class="wrapper">
			@yield('content')
		</div>
	@endauth

    @include('includes.footer')

    {{ Visitor::log() }}

	<!-- Javascript -->
	{!! scriptTimestamp('/js/main.js') !!}
	@yield('script')
</body>
</html>