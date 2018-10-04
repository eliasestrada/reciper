@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <div class="col s12 m6 offset-m3">
        <div class="center">
            <h2 class="headline">@lang('forms.change_pwd')</h2>
        </div>

        <form action="{{ action('Settings\PasswordController@update') }}" method="post">
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

            <div class="input-field mt-4 center">
                <button class="btn" type="submit">@lang('forms.save')</button>
            </div>
        </form>
    </div>
</div>

@endsection