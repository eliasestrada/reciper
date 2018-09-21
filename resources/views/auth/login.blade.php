@extends('layouts.app')

@section('title', trans('form.login'))

@section('content')

<div class="page row">
    <div class="center"><h3 class="headline">@lang('form.login')</h3></div>

    <div class="col s12 m8 offset-m2 l6 offset-l3">
        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf
            <div class="input-field">
                <input id="email" value="{{ old('email') }}" type="email" name="email" class="validate">
                <label for="email">@lang('form.email')</label>
            </div>
        
            <visibility name-attr="password" id-attr="password" class-attr="pwd">
                <label for="password" slot="content">@lang('form.pwd')</label>
                @include('includes.preloader2')
            </visibility>

            <div class="mt-3">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                    <span>
                        @lang('form.remember_me') 
                        @include('includes.tip', ['tip' => trans('form.remember_info')])
                    </span>
                </label>
            </div>
        
            <div class="input-field">
                <button type="submit" id="go-to-account" class="waves-effect waves-light btn">
                    <i class="material-icons right">exit_to_app</i>
                    @lang('form.login')
                </button>
            </div>

            {{-- <a href="{{ route('password.request') }}">@lang('form.forgot_pwd')</a> --}}
        </form>
    </div>

    <div class="col s12 m8 offset-m2 pt-4">
        <p>
            @lang('messages.dont_have_account'):
            <a href="/register">
                <span class="new badge p-1 px-2" style="float:none">@lang('form.register')</span>
            </a>
        </p>
    </div>
</div>

@endsection
