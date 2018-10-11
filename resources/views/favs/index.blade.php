@extends('layouts.app')

@section('title', trans('messages.favorites'))


@section('content')

<div class="page">
    <div class="center mb-4">
        <h1 class="headline">@lang('messages.favorites')</h1>
    </div>

    {{--  Cards  --}}
    @component('comps.card', ['recipes' => $favs]) @endcomponent
</div>

@endsection