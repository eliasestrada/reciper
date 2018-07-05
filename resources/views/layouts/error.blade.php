<!doctype html>
<html lang="{{ locale() }}">
<head>
	@include('includes.head')
	<title>@yield('title') - @lang('website.name')</title>
</head>
<body>
	<div style="background:#eee;">
		@yield('content')
	</div>
</body>
</html>