@extends('layouts.app')

@section('title', trans('auth.login'))

@section('content')

<div class="image-bg row mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1">
        <div>
            <div class="register-tabs mt-2">
                <a href="/register">@lang('auth.register')</a>
                <a href="#" class="active">@lang('auth.login')</a>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="pt-5">
            @csrf
            <div class="input-field">
                <input id="email" value="{{ old('email') }}" type="email" name="email" class="validate">
                <label for="email">@lang('forms.email')</label>
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

            {{-- <a href="{{ route('password.request') }}">@lang('forms.forgot_pwd')</a> --}}
        </form>
    </div>
</div>

@endsection
