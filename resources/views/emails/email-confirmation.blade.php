@component('comps.email')
    @slot('message')
        @lang('messages.confirm_email_message')
    @endslot
    @slot('link')
        <a href="{{ $token }}" target="_blank" style="font-family: sans-serif">
            {{ $token }}
        </a>
    @endslot
    @slot('footer')
        @lang('passwords.ignore_if_not_you')
    @endslot
@endcomponent