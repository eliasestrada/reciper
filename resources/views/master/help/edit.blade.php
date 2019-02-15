@extends('layouts.auth')

@section('title', trans('help.edit_help'))

@section('content')

@include('includes.buttons.back', ['url' => '/help'])

<div class="page row">
    <div class="col s12 m8 offset-m2">
        <div class="center">
            <h1 class="header">@lang('help.edit_help')</h1>
        </div>

        <form action="{{ action('Master\HelpController@update', ['id' => $help->id]) }}" method="post">
            @csrf
            @method('put')
            <div class="center pb-2 pt-3">
                {{-- Publich button --}}
                <button type="submit"
                    class="btn-floating tooltipped"
                    data-tooltip="@lang('tips.publish')"
                >
                    <i class="fas fa-save"></i>
                </button>

                {{-- Delete button --}}
                <form action="{{ action('Master\HelpController@destroy', ['id' => $help->id]) }}" method="post" class="d-inline-block">
                    @method('delete') @csrf

                    <button type="submit"
                        class="tooltipped confirm btn-floating red"
                        data-tooltip="@lang('forms.deleting')"
                        data-confirm="@lang('help.sure_del_help')"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                {{-- Choose category --}}
                <div class="d-inline-block ml-3">
                    <label for="category">@lang('help.help_category')</label>

                    <select name="category" id="category">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}"
                                {{ set_as_selected_if_equal($cat['id'], $help->category->id ?? '') }}
                            >
                                {{ $cat[_('title')] }}
                            </option>
                        @endforeach
                        </select>
                    </div>
            </div>

            {{-- Title field --}}
            <div class="input-field">
                <label for="title">@lang('help.help_title')</label>
                <textarea name="title"
                    id="title"
                    class="materialize-textarea counter"
                    data-length="{{ config('valid.help.title.max') }}"
                    required
                >{{ $help->getTitle() }}</textarea>
            </div>

            {{-- Text field --}}
            <div class="input-field">
                <label for="text">@lang('help.help_text')</label>
                <textarea name="text"
                    id="text"
                    class="materialize-textarea counter"
                    data-length="{{ config('valid.help.text.max') }}"
                    required
                >{{ $help->getText() }}</textarea>
            </div>
        </form>
    </div>
</div>

@endsection