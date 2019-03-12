@extends('layouts.auth')

@section('title', trans('admin.feedback'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="header">
            <i class="fas fa-comment-dots red-text"></i> 
            @lang('feedback.contact_us')
        </h1>
    </div>

    {{-- Tabs --}}
    <div v-cloak class="mt-4">
        <tabs>
            @for ($i = 0; $i < 2; $i++)
                <tab 
                    name="@lang("messages.in_{$feedback[$i]['lang']}") 
                    <span class='red-text'><b>{{ count($feedback[$i]['feeds']) }}</b></span>"
                    {{ $i === 0 ? ':selected="true"' : '' }}
                >
                    <div class="row paper-dark pt-3">
                        @forelse ($feedback[$i]['feeds'] as $feed)
                            <div class="col s12 l6">
                                <div class="card"
                                    style="min-height:200px;
                                        border-left:4px solid;
                                        border-color:{{ $feed->isReport(1) ? 'red' : 'green' }}"
                                >
                                    <div class="card-content">
                                        <span class="card-title" style="line-height:32px!important">
                                            @if ($feed->isReport(1))
                                                <b>@lang('feedback.report_recipe'):</b> 
                                                <a href="/recipes/{{ $feed->recipe->slug }}">
                                                    {{ $feed->recipe->getTitle() }}
                                                </a>
                                            @else
                                                <b>@lang('feedback.feedback')</b> 
                                            @endif
                                            <div class="divider"></div>
                                        </span>
                                        <p>{{ string_limit($feed->message) }}</p>
                                        <p class="mt-3"><b>@lang('documents.last_update'):</b></p>
                                        <p>{{ time_ago($feed->created_at) }}</p>
                                    </div>

                                    <div class="card-action">

                                        {{-- Open button --}}
                                        <a href="/admin/feedback/{{ $feed->id }}" class="btn-small mr-2">
                                            @lang('messages.open')
                                        </a>

                                        {{-- Delete button --}}
                                        <form method="post"
                                            action="{{ action('Admin\FeedbackController@destroy', ['id' => $feed->id]) }}"
                                            class="d-inline-block"
                                        >
                                            @method('delete')
                                            @csrf

                                            <button type="submit"
                                                class="btn-small red confirm"
                                                data-confirm="@lang('contact.sure_del_feed')"
                                            >
                                                @lang('forms.deleting')
                                            </button>
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
                        {{ $feedback[$i]['feeds']->links() }}
                    </div>
                </tab>
            @endfor
        </tabs>
    </div>
</div>

@endsection