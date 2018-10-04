@extends('log-viewer::custom-theme._master')

@section('content')
    <div class="page row">
        <div class="col s12 m4 l3">
            <div class="mb-4"> {{-- Log Menu --}}
                <ul class="collection">
                    <li class="collection-header px-2">
                        <h5>{{ $log->date }}</h5>
                    </li>

                    @foreach($log->menu() as $levelKey => $item)
                        @if ($item['count'] === 0)
                            <a class="collection-item d-flex justify-content-between align-center main-dark-text">
                                <span class="level-name">{{ $item['name'] }}</span>
                                <span class="badge">{{ $item['count'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['url'] }}" class="collection-item d-flex justify-content-between align-center main-dark-text {{ $level === $levelKey ? ' main-light' : ''}}">
                                <span class="level-name">{{ $item['name'] }}</span>
                                <span class="new badge">{{ $item['count'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col s12 m8 l9">
            <div class="mb-4"> {{-- Log Details --}}
                <div class="p-2">
                    {{-- Back button --}}
                    <a href="/log-viewer/logs" class="btn right">
                        <i class="fas fa-angle-right right"></i> @lang('messages.back')
                    </a>
                    {{-- Download button --}}
                    <a href="{{ route('log-viewer::logs.download', [$log->date]) }}" class="btn-floating tooltipped" data-tooltip="@lang('logs.download_file')" data-position="top">
                        <i class="fas fa-file-download"></i>
                    </a>
                    {{-- Delete button --}}
                    <form action="{{ action('Master\LogsController@delete') }}" method="POST" class="d-inline-block tooltipped" data-tooltip="@lang('logs.delete_file')" data-position="top">
                        @method('delete') @csrf
                        <input type="hidden" name="date" value="{{ $log->date }}">
                        <button type="submit" class="btn-floating red" title="@lang('forms.deleting')" onclick="if (!confirm('@lang('logs.confirm', ['date' => $log->date])')) event.preventDefault()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <ul class="collection">
                    <li class="collection-item">
                        <div>
                            <span>@lang('logs.path_to_file'):</span> 
                            {{ $log->getPath() }} <i class="fas fa-link left"></i>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span>@lang('logs.all_errors'):</span> 
                            {{ $entries->total() }} <i class="fas fa-exclamation-triangle left"></i>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span>@lang('logs.file_size'):</span> 
                            {{ $log->size() }} <i class="fas fa-memory left"></i>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span>@lang('logs.created_at'):</span> 
                            {{ $log->updatedAt() }} <i class="fas fa-calendar left"></i>
                        </div>
                    </li>
                    <li class="collection-item">
                        <div>
                            <span>@lang('logs.updated_at'):</span> 
                            {{ $log->createdAt() }} <i class="fas fa-calendar left"></i>
                        </div>
                    </li>
                </ul>
                {{-- Search --}}
                <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}" method="GET">
                    <div class="input-field">
                        <i class="fas fa-search prefix"></i>
                        <input id="search-input" name="query" value="{!! request('query') !!}" placeholder="@lang('pages.search_details')">
                    </div>
                    <button id="search-btn" class="btn">@lang('pages.search')</button>
                    @if (request()->has('query'))
                        <a href="{{ route('log-viewer::logs.show', [$log->date]) }}" class="btn">
                            @lang('forms.cancel')
                        </a>
                    @endif
                </form>
            </div>

            @if ($entries->hasPages()) {{-- Log Entries --}}
                <div>
                    <span class="badge">
                        @lang('logs.page') 
                        {!! $entries->currentPage() !!} 
                        @lang('logs.of') 
                        {!! $entries->lastPage() !!}
                    </span>
                </div>
            @endif

            <div class="row"> {{-- Log cards --}}
                @forelse($entries as $key => $entry)
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title activator main-dark-text">
                                    <div class="d-inline-block">{{ $entry->env }}</div>
                                    <div class="d-inline-block">
                                        <span class="red-text">({{ $entry->level }})</span>
                                    </div>
                                    <div class="d-inline-block">
                                        <span class="main-text"> - {{ time_ago($entry->datetime) }}</span>
                                    </div>
                                    <div class="d-inline-block right">{{ $entry->datetime->format('H:i:s') }}</div>
                                    <div class="divider my-2"></div>
                                    <div class="break-word">
                                        <div>{{ $entry->header }}</div>
                                        <div class="py-3 position-relative">
                                            <i class="fas fa-ellipsis-h fa-15x position-absolute red-text" style="right:5px;top:5px"></i>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="card-reveal">
                                <div class="py-1 position-relative">
                                    <span>{{ $entry->env }}</span> 
                                    <span class="red-text">({{ $entry->level }})</span> 
                                    {{ $entry->datetime->format('H:i:s') }}
                                    <div class="d-inline-block">
                                        <span class="main-text"> - {{ time_ago($entry->datetime) }}</span>
                                    </div>
                                    <i class="fas fa-times fa-15x card-title position-absolute red-text" style="right:5px;top:0"></i>
                                </div>
                                <div class="divider"></div>
                                <p>@if ($entry->hasStack()) {!! $entry->stack() !!} @endif</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        @component('comps.empty')
                            @slot('text')
                                @lang('log-viewer::general.empty-logs')
                            @endslot
                        @endcomponent
                    </tr>
                @endforelse
            </div>

            {!! $entries->appends(compact('query'))->render() !!}
        </div> 
    </div>
@endsection
