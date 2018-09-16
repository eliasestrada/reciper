@extends('layouts.app')

@section('title', $document->getTitle())

@section('content')

<div class="page">
    <h4>{{ $document->getTitle() }}</h4>
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

{{-- Edit button --}}
@component('comps.btns.fixed-btn')
    @slot('icon') edit @endslot
    @slot('link') /master/documents/{{ $document->id }}/edit @endslot
    @slot('tip') @lang('tips.edit') @endslot
@endcomponent

@endsection