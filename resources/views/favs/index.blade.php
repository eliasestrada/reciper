@extends('layouts.app')

@section('title', trans('messages.favorites'))


@section('content')

<div class="page">
    <div class="center mb-4">
        <h1 class="header"><i class="fas fa-star" style="color:#d49d10"></i> @lang('messages.favorites')</h1>
    </div>
    <div class="pb-3">
        @foreach ($categories as $category)
            <a href="/favs/{{ $category->id }}" class="btn btn-sort main-text {{ active_if_route_is(["/favs/$category->id"]) }} {{ $category->id == 1 ? active_if_route_is(['/favs']) : '' }}">
                <span class="pl-1">{{ $category->name }}</span>
            </a>
        @endforeach
    </div>

    {{--  Cards  --}}
    @component('comps.card', ['recipes' => $recipes]) @endcomponent
</div>

@endsection