@component('comps.error', ['btn' => false])
    @slot('error')
        @lang('errors.503')
    @endslot
    @slot('title')
        @lang('errors.503_title')
    @endslot
    @lang('errors.503_description')
@endcomponent