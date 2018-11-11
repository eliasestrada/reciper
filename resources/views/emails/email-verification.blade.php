@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
    {{ config('app.name') }}
    @endcomponent
@endslot

@lang('messages.confirm_email_message')

@slot('subcopy')
    @component('mail::subcopy')
    @lang('passwords.ignore_if_not_you')
    @endcomponent
@endslot

@component('mail::button', ['url' => $token])
    @lang('messages.email_confirmation')
@endcomponent

@slot('footer')
    @component('mail::footer')
    @lang('messages.mail_footer')
    @endcomponent
@endslot
@endcomponent
