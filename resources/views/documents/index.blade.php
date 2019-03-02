@extends(setLayout())

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
            @for ($i = 0; $i < 2; $i++)
                <tab 
                    name="@lang("messages.{$documents[$i]['name']}") 
                    <span class='red-text'><b>{{ count($documents[$i]['docs']) }}</b></span>"
                    {{ $i === 0 ? ':selected="true"' : '' }}
                >
                    <div class="row paper-dark pt-3">
                        @forelse ($documents[$i]['docs'] as $doc)
                            <div class="col s12 l6">
                                <div class="card" style="min-height:320px">
                                    <div class="card-content">
                                        <span class="card-title" style="line-height:32px!important">
                                            {{ $doc->getTitle() }}
                                        </span>

                                        <div class="divider"></div>
                                        <p>{{ string_limit(strip_tags($doc->getText()), 250) }}</p>
                                        <p class="mt-3"><b>@lang('documents.last_update'):</b></p>
                                        <p>{{ time_ago($doc->updated_at) }}</p>
                                    </div>

                                    <div class="card-action">
                                        <a href="/documents/{{ $doc->id }}" class="text">
                                            @lang('messages.open')
                                        </a>

                                        @hasRole('master')
                                            <a href="/master/documents/{{ $doc->id }}/edit" class="text">
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
                                        'link' => '/master/documents/create'
                                    ])
                                @endslot
                            @endcomponent
                        @endforelse

                        {{ $documents[$i]['docs']->links() }}
                    </div>
                </tab>
            @endfor
        </tabs>
    </div>
</div>

@hasRole('master')
    @component('comps.btns.fixed-btn')
        @slot('icon') fa-plus @endslot
        @slot('link') /master/documents/create @endslot
        @slot('tip') @lang('documents.new_doc') @endslot
    @endcomponent
@endhasRole

@endsection