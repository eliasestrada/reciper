<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - {{ config('app.name') }}</title>
</head>
<body>
	<div class="wrapper" style="padding:0 1.2rem;">
		<div class="container">
			@yield('content')
		</div>
	</div>
</body>
</html>