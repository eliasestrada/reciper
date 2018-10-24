@extends('layouts.auth')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <div class="col s12 m5 l4">
        @include('includes.settings-sidebar')
    </div>
    <div class="col s12 m7 l8 mt-3">
        <div class="row">
            <div class="col s12">
                <form action="{{ action('Settings\GeneralController@updateGeneral') }}" method="post">
                    @csrf @method('put')

                    {{-- Reciper's name --}}
                    <h2 class="header">@lang('settings.reciper_name')</h2>
                    <div class="input-field">
                        <label for="name">@lang('forms.name')</label>
                        <input type="text" name="name" id="name" value="{{ user()->name }}" data-length="{{ config('valid.settings.general.name.max') }}" class="counter" maxlength="{{ config('valid.settings.general.name.max') }}" minlength="{{ config('valid.settings.general.name.min') }}">
                    </div>
                    <div class="input-field">
                        <textarea id="status" class="materialize-textarea counter" data-length="{{ config('valid.settings.general.status.max') }}" name="status" maxlength="{{ config('valid.settings.general.status.max') }}">{{ (user()->status ?? old('status')) }}</textarea>
                        <label for="status">@lang('settings.status')</label>
                    </div>
                    <div class="input-field mt-4">
                        <button class="btn" type="submit">@lang('forms.save')</button>
                    </div>
                </form>
            </div>
            <div class="col s12">
                <h2 class="header">@lang('forms.change_pwd')</h2>
                <form action="{{ action('Settings\GeneralController@updatePassword') }}" method="post">
                    @method('put') @csrf
                    <div class="input-field">
                        <label for="old_password">@lang('forms.current_pwd')</label>
                        <input type="password" name="old_password" id="old_password" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field">
                        <label for="password">@lang('forms.new_pwd')</label>
                        <input type="password" name="password" id="password" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field">
                        <label for="password_confirmation">@lang('forms.repeat_new_pwd')</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" minlength="{{ config('valid.settings.password.min') }}" maxlength="{{ config('valid.settings.password.max') }}">
                    </div>

                    <div class="input-field mt-4">
                        <button class="btn" type="submit">@lang('forms.save')</button>
                    </div>
                </form>
                <div class="center mt-2">
                    <a href="#" class=""></a>
                    <a href="#delete-account-modal" title="@lang('settings.delete_account')" class="modal-trigger">
                        @lang('settings.delete_account')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- delete-account-modal structure -->
<div id="delete-account-modal" class="modal">
    <div class="modal-content reset">
        <form action="{{ action('UsersController@destroy', ['m' => 'd']) }}" method="post" enctype="multipart/form-data">
            @csrf @method('delete')

            <div class="center">
                <p class="mb-0 flow-text red-text">@lang('settings.delete_account')</p>
            </div>
            <p>@lang('settings.delete_account_desc')</p>

            {{-- Password --}}
            <div class="row">
                <div class="col s8">
                    <div class="input-field">
                        <input type="password" name="password" id="password" required>
                        <label for="title">@lang('settings.password')</label>
                    </div>
                </div>
                <div class="col s4">
                    {{--  Button  --}}
                    <div class="center pb-2">
                        <button type="submit" class="btn red waves-effect waves-light mt-4" onclick="if (!confirm('@lang('settings.are_you_sure_to_deactivate')')) event.preventDefault()">
                            <i class="fas fa-trash-alt left"></i>
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
