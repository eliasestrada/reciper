@extends('layouts.guest')

@section('title', trans('auth.login'))

@section('content')

<div class="image-bg row mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1">
        <div class="center pt-2">
            <h1 class="header">@lang('auth.login')</h1>
        </div>

        <form method="POST" action="{{ route('login') }}" class="px-4">
            @csrf
            <div class="input-field">
                <input id="username" value="{{ old('username') }}" type="text" name="username" class="validate">
                <label for="username">@lang('auth.username')</label>
            </div>

            <visibility inline-template>
                <div class="input-field">
                    <input class="validate with-icon" :type="type" name="password" id="password" autocomplete="off" required>
                    <div class="d-inline-block visibility-icon waves-effect waves-green" v-on:click="changeType">
                        <i :class="icon" class="fas no-select"></i>
                    </div>
                    <label for="password">@lang('forms.pwd')</label>
                </div>
            </visibility>

            <div class="mt-3">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                    <span>
                        @lang('forms.remember_me')
                        @include('includes.tip', ['tip' => trans('tips.remember_info')])
                    </span>
                </label>
            </div>

            <div class="input-field">
                <button type="submit" id="go-to-account" class="waves-effect waves-light btn">
                    @lang('auth.login')
                    <i class="fas fa-sign-in-alt right"></i>
                </button>
            </div>

            <a href="{{ route('password.request') }}" class="text text-hover">@lang('forms.forgot_pwd')</a>
        </form>
    </div>
</div>

@endsection
