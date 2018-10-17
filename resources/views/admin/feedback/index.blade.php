@extends('layouts.auth')

@section('title', trans('admin.feedback'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="header"><i class="fas fa-comment-dots red-text"></i> @lang('feedback.contact_us')</h1>
    </div>

    {{-- Tabs --}}
    <div v-cloak class="mt-4">
        <tabs>
            @for ($i = 1; $i <= 2; $i++)
                <tab 
                    @if ($i == 1)
                        name="@lang('messages.in_russian') 
                        <span class='red-text'><b>{{ $feedback_ru->count() }}</b></span>"
                        :selected="true"
                    @else
                        name="@lang('messages.in_english') 
                        <span class='red-text'><b>{{ $feedback_en->count() }}</b></span>"
                    @endif
                >
                    <div class="row paper-dark pt-3" id="tab-{{ $i }}">
                        @forelse ($i == 1 ? $feedback_ru : $feedback_en as $feed)
                            <div class="col s12 l6">
                                <div class="card" style="min-height:200px;border-left:4px solid;border-color:{{ $feed->isReport(1) ? 'red' : 'green' }};">
                                    <div class="card-content">
                                        <span class="card-title" style="line-height:32px!important">
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
                                        {{-- Open button --}}
                                        <a href="/admin/feedback/{{ $feed->id }}">@lang('messages.open')</a>
                                        {{-- Delete button --}}
                                        <a onclick="if (confirm('@lang('contact.sure_del_feed')')) $('delete-feed-{{$loop->index}}').submit()" class="red-text">
                                            @lang('tips.delete')
                                        </a>
                                        <form action="{{ action('Admin\FeedbackController@destroy', ['id' => $feed->id]) }}" method="post" id="delete-feed-{{$loop->index}}" class="hide">
                                            @method('delete') @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @component('comps.empty')
                                @slot('text')
                                    @lang('messages.no_messages')
                                @endslot
                            @endcomponent
                        @endforelse
                        {{ $i == 1 ? $feedback_ru->links() : $feedback_en->links() }}
                    </div>
                </tab>
            @endfor
        </tabs>
    </div>
</div>

@endsection