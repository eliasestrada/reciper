@extends('layouts.auth')

@section('title', trans('messages.trash'))

@section('content')

<div class="center pt-4">
    <h1 class="header">
        <i class="fas fa-trash red-text"></i> @lang('messages.trash') 
        {{ $trash->count() > 0 ? $trash->count() : '' }}
    </h1>
</div>

<div class="page">
    <div class="row">
        @forelse ($trash as $item)
            <div class="col s12 m6">
                <div class="card blue-grey darken-1">
                    <div class="card-content pt-4">
                        <span class="card-title">{!! $item->getTitle() !!}</span>

                        <p>{!! $item->getText() !!}</p>

                        <p class="pt-2 grey-text">
                            @lang('messages.deleted') 
                            {!! time_ago($item->deleted_at) !!}
                        </p>
                    </div>
                    <div class="card-action">

                        {{-- Restore form --}}
                        <form action="{{ action('Master\TrashController@update', ['id' => $item->id]) }}"
                            method="post"
                            class="d-inline-block"
                        >
                            @method('put') @csrf

                            <input type="hidden" name="table" value="help">

                            {{-- Restore button --}}
                            <button type="submit"
                                class="btn-small green confirm"
                                data-confirm="@lang('messages.sure_to_restore')"
                                title="@lang('messages.restore')"
                            >
                                <i class="fas fa-sync-alt left"></i>
                                @lang('messages.restore')
                            </button>
                        </form>

                        {{-- Delete form --}}
                        <form action="{{ action('Master\TrashController@destroy', ['id' => $item->id]) }}"
                            method="post"
                            class="d-inline-block"
                        >
                            @method('delete')
                            @csrf

                            <input type="hidden" name="table" value="help">

                            {{-- Delete button --}}
                            <button type="submit"
                                class="btn-small red confirm"
                                data-confirm="@lang('messages.sure_to_delete_trash')"
                                title="@lang('forms.deleting')"
                            >
                                <i class="fas fa-trash left"></i>
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