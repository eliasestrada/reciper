<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>
		@yield('title') - {{ config('app.name') }}
	</title>
	@yield('head')
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

	{{ Visitor::log() }}

	<!-- Javascript -->
	{!! scriptTimestamp('/js/app.js') !!}
	@yield('script')

</body>
</html>