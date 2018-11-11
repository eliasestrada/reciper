@component('mail::layout')

@slot('header')
    @include('includes.emails.header')
@endslot

@lang('passwords.we_got_request', ['username' => $name])

@slot('subcopy')
    @component('mail::subcopy')
    @lang('passwords.ignore_if_not_you')
    @endcomponent
@endslot

@component('mail::button', compact('url'))
    @lang('passwords.reset_pwd')
@endcomponent

@slot('footer')
    @component('mail::footer')
    @lang('messages.mail_footer')
    @endcomponent
@endslot

@endcomponent
