<!doctype html>
<html lang="{{ locale() }}">
<head>
	@yield('head')
	@include('includes.head')
	<title>
		@yield('title') - {{ config('app.name') }}
	</title>
</head>
<body>

	@include('includes.nav.navbar')
	@include('includes.user-sidebar')

	@yield('home-header')

	<div id="app" class="wrapper">
		@yield('content')
	</div>

    @include('includes.footer')

	<!-- Javascript -->
	{!! scriptTimestamp('/js/vue.js') !!}
	{!! scriptTimestamp('/js/vanilla.js') !!}

	@yield('script')
	@include('includes.js.dropdown')
	@include('includes.js.sidenav')
	@include('includes.js.tooltip')
	@include('includes.js.collapsible')
	@include('includes.messages')
</body>
</html>