@extends('layouts.app')

@section('title', trans('pages.feedback'))

@section('content')

<div class="page container">
    <div class="center"><h1 class="headline">@lang('pages.feedback')</h1></div>

    @if (session('success'))
        <div class="mt-4">
            @include('includes.buttons.btns')
        </div>
    @else
        <p>@lang('contact.intro')</p>
        <form action="{{ action('Admin\FeedbackController@store') }}" method="post">
            <div class="input-field"> @csrf
                <i class="fas fa-at prefix"></i>
                <input type="email" name="email" value="{{ old('email') }}" id="email">
                <label for="email">@lang('forms.email')</label>
                <span class="helper-text">@lang('forms.email_desc')</span>
            </div>
            <div class="input-field">
                <i class="fas fa-comment-alt prefix"></i>
                <textarea name="message" id="message" class="materialize-textarea counter" data-length="{{ config('validation.feedback.contact.message.max') }}" maxlength="{{ config('validation.feedback.contact.message.max') }}" minlength="{{ config('validation.feedback.contact.message.min') }}" required>{{ old('message') }}</textarea>
                <label for="message">@lang('forms.message')</label>
                <span class="helper-text">@lang('forms.message_desc')</span>
            </div>
            <div class="input-field">
                <button type="submit" class="btn btn-main">
                    @lang('forms.send')
                </button>
            </div>
        </form>
    @endif
</div>

@endsection
