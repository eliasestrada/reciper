@extends('layouts.app')

@section('title', trans('form.login'))

@section('content')

<div class="page row">
    <div class="col s12 m8 offset-m2 l6 offset-l3">
        <div class="paper">
            <div class="register-tabs">
                <a href="/register">@lang('form.register')</a>
                <a href="#" class="active">@lang('form.login')</a>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="pt-5">
            @csrf
            <div class="input-field">
                <input id="email" value="{{ old('email') }}" type="email" name="email" class="validate">
                <label for="email">@lang('form.email')</label>
            </div>
        
            <visibility inline-template>
                <div class="input-field">
                    <input class="validate" :type="type" name="password" id="password" autocomplete="off" required>
                    <i class="material-icons main-text noselect position-absolute visibility-icon" v-on:click="changeType" v-text="icon"></i>
                    <label for="password">@lang('form.pwd')</label>
                </div>
            </visibility>

            <div class="mt-3">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                    <span>
                        @lang('form.remember_me') 
                        @include('includes.tip', ['tip' => trans('tips.remember_info')])
                    </span>
                </label>
            </div>
        
            <div class="input-field">
                <button type="submit" id="go-to-account" class="waves-effect waves-light btn">
                    @lang('form.login')
                    <i class="fas fa-sign-in-alt right"></i>
                </button>
            </div>

            {{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
        </form>
    </div>
</div>

@endsection
