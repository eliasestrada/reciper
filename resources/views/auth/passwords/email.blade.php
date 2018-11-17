@extends('layouts.guest')

@section('title', trans('passwords.sent_code'))

@section('content')

<div class="image-bg row mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 corner z-depth-1 px-4">
        <div class="center mt-4"><h1 class="header">@lang('passwords.sent_code')</h1></div>

        <p>@lang('passwords.sent_code_desc')</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf <div class="input-field">
                <label for="email">@lang('forms.email')</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                @include('includes.input-error', ['field' => 'email'])
            </div>

            <div class="input-field">
                <button type="submit" class="waves-effect waves-light btn">
                    <i class="fas fa-share right"></i>
                    @lang('passwords.sent_code')
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
