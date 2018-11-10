@component('comps.email')
    @slot('title')
        @lang('passwords.reset_pwd')
    @endslot
    @slot('message')
        @lang('passwords.we_got_request', ['username' => $user->username])
    @endslot
    @slot('link')
        <a href="{{ $url }}" target="_blank" style="font-family: sans-serif">
            {{ $url }}
        </a>
    @endslot
    @slot('footer')
        @lang('passwords.ignore_if_not_you')
    @endslot
@endcomponent