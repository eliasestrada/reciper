@extends('layouts.app')

@section('title', trans('settings.general'))

@section('content')

<div class="page row">
    <form action="{{ action('Settings\GeneralController@update') }}" method="post" class="form">
        @csrf @method('put')

        {{-- Reciper's name --}}
        <div class="col s12 m6">
            <div class="center"><h2 class="headline">@lang('settings.reciper_name')</h2></div>
            <div class="input-field">
                <label for="name">@lang('form.name')</label>
                <input type="text" name="name" id="name" value="{{ user()->name }}" data-length="{{ config('validation.settings_name_max') }}" class="counter" maxlength="{{ config('validation.settings_name_max') }}" minlength="{{ config('validation.settings_name_min') }}">
            </div>
        </div>

        {{-- About me --}}
        <div class="col s12 m6">
            <div class="center"><h2 class="headline">@lang('settings.about_me')</h2></div>
            <div class="input-field">
                <textarea id="about_me" class="materialize-textarea counter" data-length="{{ config('validation.settings_about_me') }}" name="about_me" maxlength="{{ config('validation.settings_about_me') }}">{{ (user()->about_me ?? old('about_me')) }}</textarea>
                <label for="about_me">@lang('settings.about_me')</label>
            </div>
        </div>

        <div class="center"><button class="btn" type="submit">@lang('form.save')</button></div>
    </form>
</div>

@endsection