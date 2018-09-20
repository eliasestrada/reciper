@extends('layouts.app')

@section('title', trans('help.help'))

@section('content')

<div class="page">
    <p><b>{{ $help->getTitle() }}</b></p>
    <div class="divider"></div>
    <p>{!! $help->getText() !!}</p>
</div>

@endsection