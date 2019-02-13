@extends(setLayout())

@section('title', $document->getTitle())

@section('content')

<div class="page">
    @hasRole('master')
        <div class="center pb-2 pt-3">
            {{-- Back button --}}
            <a href="/documents"
                class="btn-floating green tooltipped"
                data-tooltip="@lang('messages.back')"
            >
                <i class="fas fa-angle-left"></i>
            </a>
            {{--  edit button  --}}
            <a href="/master/documents/{{ $document->id }}/edit"
                class="btn-floating green tooltipped"
                data-tooltip="@lang('tips.edit')"
            >
                <i class="fas fa-pen"></i>
            </a>
        </div>
    @endhasRole

    <div class="center">
        <h5>{{ $document->getTitle() }}</h5>
        <div class="divider"></div>
    </div>
    <div class="reset">{!! custom_strip_tags($document->getText()) !!}</div>

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