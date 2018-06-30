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
		<div class="log-nav-btns p-2">
			<a href="{{ route('log-viewer::dashboard') }}" class="waves-effect waves-light btn-small {{ activeIfRouteIs('log-viewer') }}">
				<i class="material-icons left">pie_chart</i>
				@lang('logs.dashboard')
			</a>
			<a href="{{ route('log-viewer::logs.list') }}" class="waves-effect waves-light btn-small {{ activeIfRouteIs('log-viewer/logs') }}">
				<i class="material-icons left">library_books</i>
				@lang('logs.logs')
			</a>
		</div>
		@yield('content')
	</div>

	@include('includes.footer')

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

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
