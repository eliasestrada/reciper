<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - {{ config('app.name') }}</title>
</head>
<body>
	<div class="wrapper" style="padding:0 1.2rem;">
		@yield('content')
	</div>
</body>
</html>