@extends('layouts.app')

@section('title', $document->getTitle())

@section('content')

<div class="page">
    <div class="center pb-2 pt-3">
        {{-- Back button --}}
        <a href="/master/documents" class="btn-floating green tooltipped" data-tooltip="@lang('messages.back')" data-position="top">
            <i class="material-icons">keyboard_backspace</i>
        </a>
        {{--  edit button  --}}
        <a href="/master/documents/{{ $document->id }}/edit" class="btn-floating green tooltipped" data-tooltip="@lang('tips.edit')" data-position="top">
            <i class="material-icons left">edit</i>
        </a>
    </div>

    <div class="center">
        <h5>{{ $document->getTitle() }}</h5>
        <div class="divider"></div>
    </div>
    <div class="reset">{!! custom_strip_tags($document->text) !!}</div>

    <p class="mt-5"> {{-- Created at --}}
        <b>@lang('logs.created_at'):</b> 
        {{ time_ago($document->created_at) }}
    </p>

    <p> {{-- Updated At --}}
        <b>@lang('documents.last_update'):</b> 
        {{ time_ago($document->updated_at) }}
    </p>
</div>

@endsection