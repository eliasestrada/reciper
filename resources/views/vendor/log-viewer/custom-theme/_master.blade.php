<!doctype html>
<html lang="{{ locale() }}">
<head>
	@yield('head')
	@include('includes.head')
	<title>@lang('logs.logs') {{ log_viewer()->version() }}</title>
</head>
<body>
	@include('includes.nav.navbar')

	<div id="app" class="wrapper">
		@yield('content')
	</div>

	@include('includes.footer')
</body>
	{!! scriptTimestamp('/js/vue.js') !!}
	{!! scriptTimestamp('/js/vanilla.js') !!}

	@include('includes.js.dropdown')
	@include('includes.js.sidenav')
	@include('includes.js.tooltip')
	@include('includes.js.collapsible')
	@include('includes.messages')
</html>
