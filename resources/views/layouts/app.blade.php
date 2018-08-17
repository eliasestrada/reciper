<!doctype html>
<html lang="{{ lang() }}">
<head>
	@yield('head')
	@include('includes.head')
	<title>@yield('title') - @lang('website.name')</title>
</head>
<body>

	@include('includes.nav.sidenav')
	@include('includes.nav.navbar')

	@yield('home-header')

	<div id="app" class="wrapper">
		@yield('content')
	</div>

    @include('includes.footer')

	{!! scriptTimestamp('/js/app.js') !!}

	@yield('script')
	@include('includes.js.dropdown')
	@include('includes.js.sidenav')
	@include('includes.js.tooltip')
	@include('includes.js.collapsible')
	@include('includes.messages')
</body>
</html>