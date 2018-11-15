@extends('layouts.auth')

@section('title', trans('messages.trash'))

@section('content')

<div class="page">
    <div class="row">
        @forelse ($trash as $item)
            <div class="col s12 m6 l4">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                    <span class="card-title">{!! $item->getTitle() !!}</span>
                    <p class="text">{!! str_limit($item->getText(), 177) !!}</p>
                    </div>
                    <div class="card-action">
                        {{-- Open button --}}
                        <a href="/master/trash/{{ $item->id }}" class="btn-small" title="@lang('messages.open')">
                            @lang('messages.open')
                        </a>
                        {{-- Delete button --}}
                        <form action="{{ action('Master\TrashController@destroy', ['id' => $item->id]) }}" method="post" class="d-inline-block">
                            @method('delete') @csrf

                            <input type="hidden" name="table" value="help">
                            <button type="submit" class="btn-small red confirm" data-confirm="@lang('messages.sure_to_delete_trash')" title="@lang('forms.deleting')">
                                @lang('forms.deleting')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            @component('comps.empty')
                @slot('text')
                    @lang('messages.trash_is_empty')
                @endslot
            @endcomponent
        @endforelse
        {{ $trash->links() }}
    </div>
</div>

@endsection