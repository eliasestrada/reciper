@extends('layouts.guest')

@section('title', trans('passwords.reset_pwd'))

@section('content')

<div class="image-bg row mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1 px-4">
        <div class="center mt-4"><h1 class="header">@lang('passwords.reset_pwd')</h1></div>

        <form method="POST" action="{{ route('password.request') }}">
            @csrf <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-field">
                <label for="email">@lang('forms.email')</label>
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
                    <i class="fas fa-retweet right"></i>
                    @lang('passwords.reset_pwd')
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
