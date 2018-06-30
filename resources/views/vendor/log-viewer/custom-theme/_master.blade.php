<!doctype html>
<html lang="{{ locale() }}">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	@yield('head')
	@include('includes.head')

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	{!! styleTimestamp('/css/logs.css') !!}

	<title>@yield('title') {{ log_viewer()->version() }}</title>
</head>
<body>

	@include('includes.nav.navbar')

	<div id="app" class="wrapper">
		@yield('content')
	</div>

	@include('includes.footer')

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>

    @yield('modals')
	@yield('scripts')
	{!! scriptTimestamp('/js/vue.js') !!}
	{!! scriptTimestamp('/js/vanilla.js') !!}
	@include('includes.js.dropdown')
	@include('includes.js.sidenav')
	@include('includes.js.tooltip')
	@include('includes.js.collapsible')
	@include('includes.messages')
</body>
</html>
