<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - {{ config('app.name') }}</title>
</head>
<body>
	<div class="wrapper px-5">
		<div class="container">
			@yield('content')
		</div>
	</div>
</body>
</html>