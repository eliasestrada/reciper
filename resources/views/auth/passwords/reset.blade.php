@extends('layouts.app')

@section('title', trans('passwords.reset_pwd'))

@section('content')

<div class="page">
    <div class="center"><h3 class="headline">@lang('passwords.reset_pwd')</h3></div>

    <form method="POST" action="{{ route('password.request') }}">

        @csrf <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-field">
            <label for="email">@lang('form.email')</label>
            <input id="email" type="email" name="email" value="{{ ($email ?? old('email')) }}" required autofocus>
        </div>

        <div class="input-field">
            <label for="password">@lang('passwords.new_pwd')</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="input-field">
            <label for="password-confirm">@lang('passwords.repeat_new_pwd')</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>

        <div class="input-field">
            <button type="submit" class="waves-effect waves-light btn">
                <i class="material-icons right">settings_backup_restore</i>
                @lang('passwords.reset_pwd')
            </button>
        </div>
    </form>
</div>

@endsection
