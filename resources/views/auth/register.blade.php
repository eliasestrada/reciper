@extends('layouts.guest')

@section('title', trans('auth.register'))

@section('content')

<div class="row image-bg mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1">
        <div>
            <div class="register-tabs mt-2">
                <a href="#" class="active">@lang('auth.register')</a>
                <a href="/login">@lang('auth.login')</a>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="pt-5">
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
