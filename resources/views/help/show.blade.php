@extends(auth()->check() ? 'layouts.auth' : 'layouts.guest')

@section('title', trans('help.help'))

@section('content')

@include('includes.buttons.back', ['url' => '/help'])

<div class="page">
    <h1 class="pt-4 header"><b>{{ $help->getTitle() }}</b></h1>
    <div class="divider"></div>
    <p>{!! $help->getText() !!}</p>
</div>

@hasRole('admin')
    @component('comps.btns.fixed-btn')
        @slot('icon') fa-pen @endslot
        @slot('link') /help/{{ $help->id }}/edit @endslot
        @slot('tip') @lang('help.edit_help') @endslot
    @endcomponent
@endhasRole

@endsection
