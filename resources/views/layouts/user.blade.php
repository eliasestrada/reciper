<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - Delicious Food</title>
	@yield('head')
</head>
<body>

	@include('includes.navbar')
	
	@include('includes.user-sidebar')

	<div class="wrapper wrapper-user">
		@include('includes.messages')
		@yield('content')
	</div>

    @include('includes.footer')

    {{ Visitor::log() }}

    <!-- Javascript -->
	{!! scriptTimestamp('/js/main.js') !!}
	@yield('script')
</body>
</html>