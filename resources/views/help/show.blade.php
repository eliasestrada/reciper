@extends('layouts.app')

@section('title', trans('messages.help'))

@section('content')

@include('includes.buttons.back', ['url' => '/help'])

<div class="page">
    <p class="pt-4"><b>{{ $help->getTitle() }}</b></p>
    <div class="divider"></div>
    <p>{!! $help->getText() !!}</p>
</div>

@endsection