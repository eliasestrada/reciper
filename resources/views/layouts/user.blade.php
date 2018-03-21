<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - Delicious Food</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')

	@include('includes.profile-menu-line')

	@include('includes.messages')

	<div class="wrapper">
		@yield('content')
	</div>

    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
	<script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
</body>
</html>