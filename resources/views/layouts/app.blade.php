<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@yield('head')
	@include('includes.head')
	<title>
		@yield('title') - {{ config('app.name') }}
	</title>
</head>
<body>

	@include('includes.navbar')

	@include('includes.user-sidebar')

	<div class="wrapper">

		<div class="loading" id="loading"></div>
		<h4 class="loading-title" id="loading-title">@lang('includes.loading') ...</h4>

		@include('includes.messages')

		@yield('content')

	</div>

    @include('includes.footer')

	<!-- Javascript -->
	{!! scriptTimestamp('/js/app.js') !!}
	@yield('script')
</body>
</html>