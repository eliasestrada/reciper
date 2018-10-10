@extends('layouts.app')

@section('title', trans('auth.register'))

@section('content')

<div class="page row">
    <div class="col s12 m8 offset-m2 l6 offset-l3">
        <div class="paper">
            <div class="register-tabs">
                <a href="#" class="active">@lang('auth.register')</a>
                <a href="/login">@lang('auth.login')</a>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="pt-5">
            @csrf
            <div class="input-field">
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="validate" required>
                <label for="name">
                    @lang('settings.reciper_name') 
                    @include('includes.tip', ['tip' => trans('forms.name_desc')])
                </label>
            </div>

            <div class="input-field">
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="validate" required>
                <label for="email">
                    @lang('forms.email')
                    @include('includes.tip', ['tip' => trans('forms.email_desc')])
                </label>
            </div>

            <visibility inline-template>
                <div class="input-field">
                    <input class="validate with-icon" :type="type" name="password" id="password" autocomplete="off" required>
                    <div class="d-inline-block visibility-icon waves-effect waves-green" v-on:click="changeType">
                        <i :class="icon" class="fas no-select"></i>
                    </div>
                    <label for="password">
                        @lang('forms.pwd')
                        @include('includes.tip', ['tip' => trans('forms.pwd_desc')])
                    </label>
                </div>
            </visibility>

            <visibility inline-template>
                <div class="input-field">
                    <input class="validate with-icon" :type="type" name="password_confirmation" id="password_confirmation" autocomplete="off" required>
                    <div class="d-inline-block visibility-icon waves-effect waves-green" v-on:click="changeType">
                        <i :class="icon" class="fas no-select"></i>
                    </div>
                    <label for="password_confirmation">
                        @lang('forms.pwd_confirm')
                        @include('includes.tip', ['tip' => trans('forms.pwd2_desc')])
                    </label>
                </div>
            </visibility>

            @if(!empty($document))
                <blockquote class="mt-5">
                    {!! trans('forms.agree_to_terms', ['btn' => trans('auth.register')]) !!}
                </blockquote>

                <!-- show-document-modal structure -->
                <div id="show-document-modal" class="modal">
                    <div class="modal-content reset">
                        <h4>{{ $document->getTitle() }}</h4>
                        {!! $document->getText() !!}
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class="modal-close waves-effect waves-green btn-flat left">
                            @lang('messages.agree')
                        </a>
                    </div>
                </div>
            @endif

            <button type="submit" id="register-btn" class="waves-effect waves-light btn mt-3">
                @lang('auth.register')
            </button>
        </form>
    </div>
</div>

@endsection
