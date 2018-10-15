@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <div class="col s12 m4 l3">
        @include('includes.settings-sidebar', ['route' => 'general'])
    </div>
    <div class="col s12 m8 l9 mt-3">
        <div class="row">
            <div class="col s12 m6">
                <form action="{{ action('Settings\GeneralController@updateGeneral') }}" method="post">
                    @csrf @method('put')

                    {{-- Reciper's name --}}
                    <h2 class="header">@lang('settings.reciper_name')</h2>
                    <div class="input-field">
                        <label for="name">@lang('forms.name')</label>
                        <input type="text" name="name" id="name" value="{{ user()->name }}" data-length="{{ config('valid.settings.general.name.max') }}" class="counter" maxlength="{{ config('valid.settings.general.name.max') }}" minlength="{{ config('valid.settings.general.name.min') }}">
                    </div>
                    <div class="input-field">
                        <textarea id="status" class="materialize-textarea counter" data-length="{{ config('valid.settings.general.status.max') }}" name="status" maxlength="{{ config('valid.settings.general.status.max') }}">{{ (user()->status ?? old('status')) }}</textarea>
                        <label for="status">@lang('settings.status')</label>
                    </div>
                    <div class="input-field mt-4">
                        <button class="btn" type="submit">@lang('forms.save')</button>
                    </div>
                </form>
            </div>
            <div class="col s12 m6">
                <h2 class="header">@lang('forms.change_pwd')</h2>
                <form action="{{ action('Settings\GeneralController@updatePassword') }}" method="post">
                    @method('put') @csrf
                    <div class="input-field">
                        <label for="old_password">@lang('forms.current_pwd')</label>
                        <input type="password" name="old_password" id="old_password" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field">
                        <label for="password">@lang('forms.new_pwd')</label>
                        <input type="password" name="password" id="password" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field">
                        <label for="password_confirmation">@lang('forms.repeat_new_pwd')</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field mt-4">
                        <button class="btn" type="submit">@lang('forms.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @include('includes.js.collapsible')
@endsection