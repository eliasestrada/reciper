@extends('layouts.app')

@section('title', trans('visitors.visitors'))

@section('content')

<div class="page">
    <div class="center mb-3">
        <h1 class="headline mb-4">
            @lang('visitors.visitors'): <span class="red-text">{{ $visitors->count() }}</span>
        </h1>
        <div class="divider"></div>
    </div>
    <div class="row container">
        <ul class="col s12 m6">
            <li><i class="main-text material-icons tiny">remove_red_eye</i> - @lang('visitors.all_views')</li>
            <li><i class="main-text material-icons tiny">favorite</i> - @lang('visitors.gave_likes')</li>
            <li><i class="main-text material-icons tiny">library_books</i> - @lang('visitors.recipes_viewed')</li>
        </ul>
        <ul class="col s12 m6">
            <li><i class="green-text material-icons tiny">lens</i> - @lang('visitors.registered_users')</li>
            <li><i class="main-text material-icons tiny">lens</i> - @lang('visitors.not_registered_users')</li>
            <li><i class="red-text material-icons tiny">lens</i> - @lang('visitors.banned_users')</li>
        </ul>
    </div>

    <table class="responsive striped">
        <div class="divider"></div>
        <thead>
            <tr>
                <th class="main-text pl-3">#</th>
                <th><i class="material-icons main-text" title="@lang('visitors.recipes_viewed')">library_books</i></th>
                <th><i class="material-icons main-text" title="@lang('visitors.gave_likes')">favorite</i></th>
                <th><i class="material-icons main-text" title="@lang('visitors.all_views')">remove_red_eye</i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitors as $visitor)
                <tr>
                    <td class="py-1">
                        <a href="/master/visitors/{{ $visitor->id }}">
                            <span class="z-depth-1 new badge {{ $visitor->user ? 'green' : '' }}">
                                {{ $visitor->id }}
                            </span>
                        </a>
                    </td>
                    <td class="py-1 pl-2">{{ $visitor->likes->count() }}</td>
                    <td class="py-1 pl-2">{{ $visitor->views->count() }}</td>
                    <td class="py-1 pl-2">{{ $visitor->views->sum('visits') }}</td>
                </tr>
            @endforeach
            {{ $visitors->links() }}
        </tbody>
    </table>
</div>

@endsection