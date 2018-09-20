@extends('layouts.app')

@section('title', trans('help.help'))

@section('content')

{{-- Back button --}}
<a href="/help" class="btn-floating mt-3 paper-dark tooltipped" data-tooltip="@lang('messages.back')" data-position="top">
    <i class="material-icons red-text">keyboard_backspace</i>
</a>

<div class="page">
    <p><b>{{ $help->getTitle() }}</b></p>
    <div class="divider"></div>
    <p>{!! $help->getText() !!}</p>
</div>

@endsection