@extends('layouts.app')

@section('title', trans('passwords.sent_code'))

@section('content')

<div class="wrapper">
    <div class="center"><h3 class="headline">@lang('passwords.sent_code')</h3></div>
    <p>@lang('passwords.sent_code_desc')</p>

    <form method="POST" action="{{ route('password.email') }}">

        @csrf <div class="input-field">
            <label for="email">@lang('forms.email')</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="input-field">
            <button type="submit" class="waves-effect waves-light btn">
                <i class="fas fa-share right"></i>
                @lang('passwords.sent_code')
            </button>
        </div>
    </form>
</div>

@endsection
