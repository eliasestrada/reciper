@extends('layouts.app')

@section('title', trans('messages.help'))

@section('content')

{{-- Back button --}}
<a href="/help" class="btn-floating mt-3 ml-3 paper-dark tooltipped" data-tooltip="@lang('messages.back')">
    <i class="fas fa-angle-left red-text"></i>
</a>

<div class="page">
    <p><b>{{ $help->getTitle() }}</b></p>
    <div class="divider"></div>
    <p>{!! $help->getText() !!}</p>
</div>

@endsection