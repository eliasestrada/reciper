@extends('layouts.app')

@section('title', trans('documents.documents'))

@section('content')

<div class="center pt-4"><h1 class="headline">@lang('documents.documents')</h1></div>
<div class="page">
    <ul class="tabs">
        <li class="tab"><a href="#tab-1" class="active">@lang('messages.published')</a></li>
        <li class="tab"><a href="#tab-2">@lang('messages.drafts')</a></li>
    </ul>

    {{-- To prevent repeating all markup 2 times for unready and ready docs
        I put this loop that is gonna repeat code for both types of docs --}}
    @for ($i = 1; $i <= 2; $i++)
        <div class="row paper-dark pt-3" id="tab-{{ $i }}">
            {{-- This is regulat loop that loops through docs collection --}}
            @forelse ($i == 1 ? $ready_docs : $unready_docs as $doc)
                <div class="col s12 l6">
                    <div class="card" style="min-height:320px">
                        <div class="card-content">
                            <span class="card-title" style="line-height:32px!important">{{ $doc->getTitle() }}</span>
                            <div class="divider"></div>
                            <p>{{ str_limit(strip_tags($doc->text), 250) }}</p>
                            <p class="mt-3"><b>@lang('documents.last_update'):</b></p>
                            <p>{{ time_ago($doc->updated_at) }}</p>
                        </div>
                        <div class="card-action">
                            <a href="/documents/{{ $doc->id }}">@lang('messages.open')</a>
                            <a href="/master/documents/{{ $doc->id }}/edit">@lang('messages.edit')</a>
                        </div>
                    </div>
                </div>
            @empty
                @component('comps.empty')
                    @slot('text')
                        @lang('documents.no_docs')
                        @include('includes.buttons.btn', [
                            'title' => trans('documents.new_doc'),
                            'icon' => 'add',
                            'link' => '/master/documents/create'
                        ])
                    @endslot
                @endcomponent
            @endforelse

            {{ $i == 1 ? $ready_docs->links() : $unready_docs->links() }}
        </div>    
    @endfor
</div>

@component('comps.btns.fixed-btn')
    @slot('icon') fa-plus @endslot
    @slot('link') /master/documents/create @endslot
    @slot('tip') @lang('documents.new_doc') @endslot
@endcomponent

@endsection

@section('script')
    @include('includes.js.tabs')
@endsection