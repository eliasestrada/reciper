@extends('layouts.auth')

@section('title', trans('help.new_help'))

@section('content')

@include('includes.buttons.back', ['url' => '/help'])

<div class="page row">
    <div class="col s12 m8 offset-m2">
        <div class="center">
            <h1 class="header">@lang('help.new_help')</h1>
        </div>

        <form action="{{ action('Master\HelpController@store') }}" method="post"> @csrf
            <div class="center pb-2 pt-3">
                <button type="submit"
                    class="btn-floating tooltipped"
                    data-tooltip="@lang('tips.publish')"
                >
                    <i class="fas fa-check"></i>
                </button>
                <div class="d-inline-block ml-4">
                    <label for="category">@lang('help.help_category')</label>
                    <select name="category" id="category">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}">
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
                >{{ old('title') }}</textarea>
            </div>

            {{-- Text field --}}
            <div class="input-field">
                <label for="text">@lang('help.help_text')</label>
                <textarea name="text"
                    id="text"
                    class="materialize-textarea counter"
                    data-length="{{ config('valid.help.text.max') }}"
                    required
                >{{ old('text') }}</textarea>
            </div>
        </form>
    </div>
</div>

@endsection