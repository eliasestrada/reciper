@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <div class="col s12 m6">
        <div class="center">
            <h2 class="headline">@lang('settings.reciper_name')</h2>
        </div>

        <form action="{{ action('Settings\SettingsGeneralController@update') }}" method="post" class="form">
            <div class="input-field"> @csrf @method('put')
                <label for="name">@lang('form.name')</label>
                <input type="text" name="name" id="name" value="{{ user()->name }}">
            </div>

            <div class="input-field mt-4 center">
                <button class="btn" type="submit">@lang('form.save')</button>
            </div>
        </form>
    </div>
    <div class="col s12 m6">
        <div class="center">
            <h2 class="headline">@lang('settings.about_me')</h2>
        </div>

        <form action="{{ action('Settings\SettingsGeneralController@update') }}" method="post" class="form">
            <div class="input-field"> @csrf @method('put')
                <label for="name">@lang('form.name')</label>
                <input type="text" name="name" id="name" value="{{ user()->name }}">
            </div>

            <div class="input-field mt-4 center">
                <button class="btn" type="submit">@lang('form.save')</button>
            </div>
        </form>
    </div>
</div>

@endsection