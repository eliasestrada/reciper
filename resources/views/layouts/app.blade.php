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

	<div class="wrapper pb-5" id="app">
		<div class="container">
			<div class="loading" id="loading"></div>
			<h4 class="loading-title" id="loading-title">@lang('includes.loading') ...</h4>
	
			@include('includes.messages')
	
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