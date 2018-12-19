@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('documents.documents'))

@section('content')

<div class="center pt-4">
    <h1 class="header">
        <i class="fas fa-copy red-text"></i> @lang('documents.documents')
    </h1>
</div>

<div class="page">
    <div v-cloak>
        <tabs>
            @for ($i = 1; $i <= 2; $i++)
                <tab 
                    @if ($i == 1)
                        name="@lang('messages.published') 
                        <span class='red-text'><b>{{ $ready_docs->count() }}</b></span>"
                        :selected="true"
                    @elseif (user() && user()->hasRole('master'))
                        name="@lang('messages.drafts') 
                        <span class='red-text'><b>{{ $unready_docs->count() }}</b></span>"
                    @endif
                >
                    <div class="row paper-dark pt-3" id="tab-{{ $i }}">
                        {{-- This is regulat loop that loops through docs collection --}}
                        @forelse ($i == 1 ? $ready_docs : $unready_docs as $doc)
                            <div class="col s12 l6">
                                <div class="card" style="min-height:320px">
                                    <div class="card-content">
                                        <span class="card-title" style="line-height:32px!important">{{ $doc->getTitle() }}</span>
                                        <div class="divider"></div>
                                        <p>{{ str_limit(strip_tags($doc->getText()), 250) }}</p>
                                        <p class="mt-3"><b>@lang('documents.last_update'):</b></p>
                                        <p>{{ time_ago($doc->updated_at) }}</p>
                                    </div>
                                    <div class="card-action">
                                        <a href="/documents/{{ $doc->id }}" class="text">@lang('messages.open')</a>
                                        @hasRole('master')
                                            <a href="/documents/{{ $doc->id }}/edit" class="text">
                                                @lang('messages.edit')
                                            </a>
                                        @endhasRole
                                    </div>
                                </div>
                            </div>
                        @empty
                            @component('comps.empty')
                                @slot('text')
                                    @lang('documents.no_docs')
                                    @include('includes.buttons.btn', [
                                        'title' => trans('documents.new_doc'),
                                        'icon' => 'fa-plus',
                                        'link' => '/documents/create'
                                    ])
                                @endslot
                            @endcomponent
                        @endforelse

                        {{ $i == 1 ? $ready_docs->links() : $unready_docs->links() }}
                    </div>
                </tab>
            @endfor
        </tabs>
    </div>
</div>

@hasRole('master')
    @component('comps.btns.fixed-btn')
        @slot('icon') fa-plus @endslot
        @slot('link') /documents/create @endslot
        @slot('tip') @lang('documents.new_doc') @endslot
    @endcomponent
@endhasRole

@endsection