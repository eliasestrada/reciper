@extends('layouts.auth')

@section('title', trans('help.edit_help'))

@section('content')

@include('includes.buttons.back', ['url' => '/help'])

<div class="page row">
    <div class="col s12 m8 offset-m2">
        <div class="center">
            <h1 class="header">@lang('help.edit_help')</h1>
        </div>

        <form action="{{ action('HelpController@update', ['id' => $help->id]) }}" method="post">
            @csrf
            @method('put')
            <div class="center pb-2 pt-3">
                {{-- Publich button --}}
                <button type="submit" class="btn-floating tooltipped" data-tooltip="@lang('tips.publish')">
                    <i class="fas fa-save"></i>
                </button>

                {{-- Delete button --}}
                <a onclick="if (confirm('@lang('help.sure_del_help')')) $('delete-help').submit()" class="btn-floating red tooltipped" data-tooltip="@lang('tips.delete')">
                    <i class="fas fa-trash"></i>
                </a>

                {{-- Choose category --}}
                <div class="d-inline-block ml-3">
                    <label for="category">@lang('help.help_category')</label>

                    <select name="category" id="category">
                        @foreach ($categories as $c)
                            <option value="{{ $c['id'] }}" {{ set_as_selected_if_equal($c['id'], ($help->category->id ?? '')) }}>
                                {{ $c['title'] }}
                            </option>
                        @endforeach
                        </select>
                    </div>
            </div>

            <div class="input-field"> {{-- Title field --}}
                <label for="title">@lang('help.help_title')</label>
                <textarea name="title" id="title" class="materialize-textarea counter" data-length="{{ config('valid.help.title.max') }}" required>{{ $help->getTitle() }}</textarea>
            </div>

            <div class="input-field"> {{-- Text field --}}
                <label for="text">@lang('help.help_text')</label>
                <textarea name="text" id="text" class="materialize-textarea counter" data-length="{{ config('valid.help.text.max') }}" required>{{ $help->getText() }}</textarea>
            </div>
        </form>
    </div>
</div>

<form action="{{ action('HelpController@destroy', ['id' => $help->id]) }}" method="post" id="delete-help" class="hide">
    @method('delete') @csrf
</form>

@endsection