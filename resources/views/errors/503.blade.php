@component('comps.error', ['btn' => false])
    @slot('error') @endslot
    @slot('title')
        @lang('errors.503_title')
    @endslot
    @lang('errors.503_description')
@endcomponent