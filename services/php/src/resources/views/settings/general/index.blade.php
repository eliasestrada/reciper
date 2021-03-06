@extends('layouts.auth')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <div class="col s12 m5 l4 mt-2">
        @include('includes.settings-sidebar')
    </div>
    <div class="col s12 m7 l8 mt-3">
        <div class="row">
            <div class="col s12 paper-dark settings-section mt-0">

                {{-- General setting form --}}
                <form action="{{ action('Settings\GeneralController@updateGeneral') }}" method="post">
                    @csrf
                    @method('put')

                    {{-- Name --}}
                    <h2 class="header">@lang('settings.reciper_name')</h2>
                    <div class="input-field">
                        <label for="name">@lang('forms.name')</label>
                        <input type="text"
                            id="name"
                            name="name"
                            value="{{ user()->name }}"
                            data-length="{{ config('valid.settings.general.name.max') }}"
                            class="counter"
                            minlength="{{ config('valid.settings.general.name.min') }}"
                            maxlength="{{ config('valid.settings.general.name.max') }}"
                        >
                        @include('includes.input-error', ['field' => 'name'])
                    </div>

                    {{-- Status --}}
                    <div class="input-field">
                        <textarea id="status"
                            class="materialize-textarea counter"
                            data-length="{{ config('valid.settings.general.status.max') }}"
                            name="status"
                            maxlength="{{ config('valid.settings.general.status.max') }}"
                        >{{ (user()->status ?? old('status')) }}</textarea>

                        <label for="status">@lang('settings.status')</label>

                        @include('includes.input-error', ['field' => 'status'])
                    </div>

                    {{-- Save button --}}
                    <button class="btn-small mt-2" type="submit">
                        <i class="fas fa-save left"></i>
                        @lang('forms.save')
                    </button>
                </form>
            </div>

            {{-- Change Email --}}
            <div class="col s12 paper-dark settings-section">
                <form action="{{ action('Settings\GeneralController@updateEmail') }}" method="post">
                    @csrf
                    @method('put')

                    <h2 class="header">@lang('forms.email')</h2>

                    <div class="input-field">
                        <label for="email">
                            @lang('forms.email_desc')
                            @include('includes.tip', ['tip' => trans('tips.email_settings_tip')])
                        </label>
                        <input type="text"
                            name="email"
                            id="email"
                            value="{{ user()->email }}"
                            data-length="{{ config('valid.settings.email.max') }}"
                            class="counter"
                            maxlength="{{ config('valid.settings.email.max') }}"
                        />

                        @include('includes.input-error', ['field' => 'email'])

                        @if (!empty(user()->email))
                            <span class="helper-text {{ user()->verified() ? 'green' : 'red' }}-text">
                                {!! user()->verified()
                                    ? trans('settings.verified')
                                    : trans('settings.not_verified') !!}
                            </span>
                        @endif
                    </div>

                    {{-- Save button --}}
                    <button class="btn-small mt-2" type="submit">
                        <i class="fas fa-save left"></i>
                        @lang('forms.save')
                    </button>
                </form>
            </div>

            {{-- Change Password Form --}}
            <div class="col s12 paper-dark settings-section">
                <h2 class="header">@lang('forms.change_pwd')</h2>

                <form action="{{ action('Settings\GeneralController@updatePassword') }}" method="post">
                    @method('put')
                    @csrf

                    {{-- Old password input --}}
                    <div class="input-field">
                        <label for="old_password">@lang('forms.current_pwd')</label>
                        <input type="password"
                            name="old_password"
                            id="old_password"
                            minlength="{{ config('valid.settings.password.min') }}"
                            maxlength="{{ config('valid.settings.password.max') }}"
                        />
                        @include('includes.input-error', ['field' => 'old_password'])
                    </div>

                    {{-- Password input --}}
                    <div class="input-field">
                        <label for="new_password">@lang('forms.new_pwd')</label>
                        <input type="password"
                            name="password"
                            id="new_password"
                            minlength="{{ config('valid.settings.password.min') }}"
                            maxlength="{{ config('valid.settings.password.max') }}"
                        />
                        @include('includes.input-error', ['field' => 'password'])
                    </div>

                    {{-- Confirm password input --}}
                    <div class="input-field">
                        <label for="password_confirmation">@lang('forms.repeat_new_pwd')</label>
                        <input type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            minlength="{{ config('valid.settings.password.min') }}"
                            maxlength="{{ config('valid.settings.password.max') }}"
                        />
                    </div>

                    {{-- Save button --}}
                    <button class="btn-small mt-2" type="submit">
                        <i class="fas fa-save left"></i>
                        @lang('forms.save')
                    </button>
                </form>
            </div>
        </div>

        {{-- Delete account modal --}}
        <div class="center">
            <a href="#delete-account-modal"
                title="@lang('settings.delete_account')"
                class="modal-trigger red-text"
                id="_modal-trigger"
            >
                @lang('settings.delete_account')
            </a>
        </div>
    </div>
</div>

<!-- delete-account-modal structure -->
<div id="delete-account-modal" class="modal">
    <div class="modal-content reset">
        <form action="{{ action('UserController@destroy', ['m' => 'd']) }}" method="post" enctype="multipart/form-data">
            @csrf @method('delete')

            <div class="center">
                <p class="mb-0 flow-text red-text">@lang('settings.delete_account')</p>
            </div>
            <p>@lang('settings.delete_account_desc')</p>

            {{-- Delete account Password --}}
            <div class="row">
                <div class="col s8">
                    <div class="input-field">
                        <input type="password" name="password" id="password" required>
                        <label for="title">@lang('settings.password')</label>
                    </div>
                </div>
                <div class="col s4">
                    {{--  Delete account Button  --}}
                    <div class="center pb-2">
                        <button type="submit" class="btn red waves-effect waves-light mt-4 confirm" data-confirm="@lang('settings.are_you_sure_to_deactivate')">
                            <i class="fas fa-trash-alt left" id="_delete-account-button"></i>
                            @lang('forms.deleting')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
    @include('includes.js.collapsible')
@endsection
