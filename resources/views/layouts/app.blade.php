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

	@include('includes.navbar')

	@include('includes.user-sidebar')

	@yield('home-header')

	<div class="wrapper pb-5" id="app">

		@include('includes.messages')

		<div class="container">
			<div class="loading" id="loading"></div>
			<h4 class="loading-title" id="loading-title">@lang('includes.loading') ...</h4>
	
			@yield('content')
		</div>
	</div>

    @include('includes.footer')

	<!-- Javascript -->
	{!! scriptTimestamp('/js/vue.js') !!}
	{!! scriptTimestamp('/js/vanilla.js') !!}
	@yield('script')
</body>
</html>