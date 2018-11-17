@extends('layouts.guest')

@section('title', trans('auth.register'))

@section('content')

<div class="row image-bg mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1">
        <div class="center pt-2">
            <h1 class="header">@lang('auth.register')</h1>
        </div>

        <form method="POST" action="{{ route('register') }}" class="px-4">
            @csrf
            <div class="input-field">
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="validate" required>
                <label for="username">
                    @lang('auth.username')
                    @include('includes.tip', ['tip' => trans('auth.username_desc')])
                </label>
            </div>

            <visibility inline-template>
                <div class="input-field">
                    <input :type="type" id="password" name="password" class="validate with-icon" autocomplete="off" required>
                    <div class="d-inline-block visibility-icon waves-effect waves-green _eye-icon-1" v-on:click="changeType">
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
                    <input :type="type" id="password_confirmation" name="password_confirmation" class="validate with-icon" autocomplete="off" required>
                    <div class="d-inline-block visibility-icon waves-effect waves-green _eye-icon-2" v-on:click="changeType">
                        <i :class="icon" class="fas no-select"></i>
                    </div>
                    <label for="password_confirmation">
                        @lang('forms.pwd_confirm')
                        @include('includes.tip', ['tip' => trans('forms.pwd2_desc')])
                    </label>
                </div>
            </visibility>

            @if(isset($document))
                <blockquote class="mt-5">
                    {!! trans('forms.agree_to_terms', ['btn' => trans('auth.register')]) !!}
                </blockquote>
            @endif

            <button type="submit" id="register-btn" class="waves-effect waves-light btn mt-3">
                @lang('auth.register')
            </button>
        </form>
    </div>
</div>

<!-- show-document-modal structure -->
@if(isset($document))
    <div id="show-document-modal" class="modal">
        <div class="modal-content reset">
            <h4>{{ $document['title'] }}</h4>
            {!! $document['text'] !!}
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat left">
                @lang('messages.agree')
            </a>
        </div>
    </div>
@endif

@endsection
