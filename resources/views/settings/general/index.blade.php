@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <form action="{{ action('Settings\GeneralController@updateGeneral') }}" method="post" class="form">
        @csrf @method('put')

        {{-- Reciper's name --}}
        <div class="col s12 m6 pb-3">
            <div class="center"><h2 class="headline">@lang('settings.reciper_name')</h2></div>
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
        </div>
    </form>

    <div class="col s12 m6">
        <div class="center">
            <h2 class="headline">@lang('forms.change_pwd')</h2>
        </div>

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

@endsection
