<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?ver={{ env('APP_VER') }}">
<link rel="stylesheet" href="{{ asset('css/media.css') }}?ver={{ env('APP_VER') }}">

<!-- Links -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="{{ asset('favicon.png') }}?ver={{ env('APP_VER') }}" type="image/x-icon">
