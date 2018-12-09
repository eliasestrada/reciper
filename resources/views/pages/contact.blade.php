@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('feedback.feedback'))

@section('content')

<div class="image-bg row mb-0">
    <div class="col s12 m6 offset-m3 form-wrapper my-5 frames z-depth-1 px-4">
        <div class="center mt-4"><h1 class="header">@lang('feedback.feedback')</h1></div>

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
                    @include('includes.input-error', ['field' => 'email'])
                </div>
                <div class="input-field">
                    <i class="fas fa-comment-alt prefix"></i>
                    <textarea name="message" id="message" class="materialize-textarea counter" data-length="{{ config('valid.feedback.contact.message.max') }}" maxlength="{{ config('valid.feedback.contact.message.max') }}" minlength="{{ config('valid.feedback.contact.message.min') }}" required>{{ old('message') }}</textarea>
                    <label for="message">@lang('forms.message')</label>
                    @include('includes.input-error', ['field' => 'message'])
                </div>
                <div class="input-field">
                    <button type="submit" class="btn btn-main">
                        <i class="fas fa-envelope left w20"></i>
                        @lang('forms.send')
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

@endsection
