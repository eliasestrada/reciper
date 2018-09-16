@extends('layouts.app')

@section('title', trans('admin.feedback'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline">@lang('includes.feedback')</h1>
    </div>


    <ul class="tabs mt-4">
        <li class="tab">
            <a href="#tab-1" class="active">
                @lang('messages.in_russian') 
                <span class="red-text">({{ $feedback_ru->count() }})</span>
            </a>
        </li>
        <li class="tab">
            <a href="#tab-2">
                @lang('messages.in_english') 
                <span class="red-text">({{ $feedback_en->count() }})</span>
            </a>
        </li>
    </ul>

    {{-- To prevent repeating all markup 2 times for unready and ready docs
        I put this loop that is gonna repeat code for both types of docs --}}
    @for ($i = 1; $i <= 2; $i++)
        <div class="row paper-dark pt-3" id="tab-{{ $i }}">
            {{-- This is regulat loop that loops through docs collection --}}
            @forelse ($i == 1 ? $feedback_ru : $feedback_en as $feed)
                <div class="col s12 l6">
                    <div class="card" style="min-height:200px;border-left:4px solid;border-color:{{ $feed->isReport(1) ? 'red' : 'green' }};">
                        <div class="card-content">
                            <span class="card-title">
                                @if ($feed->isReport(1))
                                    <b>@lang('feedback.report_recipe'):</b> 
                                    <a href="/recipes/{{ $feed->recipe->id }}">{{ $feed->recipe->getTitle() }}</a>
                                @else
                                    <b>@lang('feedback.feedback')</b> 
                                @endif
                                <div class="divider"></div>
                            </span>
                            <p>{{ str_limit($feed->message) }}</p>
                            <p class="mt-3"><b>@lang('documents.last_update'):</b></p>
                            <p>{{ time_ago($feed->created_at) }}</p>
                        </div>
                        <div class="card-action">
                            <a href="/admin/feedback/{{ $feed->id }}" class="main-dark-text">
                                @lang('messages.open')
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @component('comps.empty')
                    @slot('text')
                        @lang('admin.no_messages')
                    @endslot
                @endcomponent
            @endforelse

            {{ $i == 1 ? $feedback_ru->links() : $feedback_en->links() }}
        </div>
    @endfor
</div>

@endsection

@section('script')
    @include('includes.js.tabs')
@endsection