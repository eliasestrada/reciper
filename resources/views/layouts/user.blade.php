<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - Delicious Food</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')

	@include('includes.messages')

	<div class="wrapper" style="padding-top: 4em;">
		@include('includes.profile-menu-line')
		@yield('content')
	</div>

    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
	{!! scriptTimestamp('/js/main.js') !!}
	@yield('script')
</body>
</html>