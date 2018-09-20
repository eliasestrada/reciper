@extends('layouts.app')

@section('title', trans('help.help'))

@section('content')

<div class="page">
    <div class="center"><h1 class="headline">@lang('help.help')</h1></div>

    <ul class="browser-default mt-5">
        @foreach ($help as $h)
            <li><a href="/help/{{ $h->id }}" style="font-size:1.2em;">{{ $h->getTitle() }}</a></li>
        @endforeach
    </ul>
</div>

@endsection