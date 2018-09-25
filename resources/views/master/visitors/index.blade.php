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
            <li><i class="main-text fas fa-eye tiny"></i> - @lang('visitors.all_views')</li>
            <li><i class="main-text fas fa-heart tiny"></i> - @lang('visitors.gave_likes')</li>
            <li><i class="main-text fas fa-book-reader tiny"></i> - @lang('visitors.recipes_viewed')</li>
        </ul>
        <ul class="col s12 m6">
            <li><i class="green-text fas fa-circle tiny"></i> - @lang('visitors.registered_users')</li>
            <li><i class="main-text fas fa-circle tiny"></i> - @lang('visitors.not_registered_users')</li>
            <li><i class="red-text fas fa-circle tiny"></i> - @lang('visitors.banned_users')</li>
        </ul>
    </div>

    <table class="responsive striped highlight">
        <div class="divider"></div>
        <thead>
            <tr>
                <th class="main-text pl-3">#</th>
                <th><i class="fas fa-book-reader main-text" title="@lang('visitors.recipes_viewed')"></i></th>
                <th><i class="fas fa-heart main-text" title="@lang('visitors.gave_likes')"></i></th>
                <th><i class="fas fa-eye main-text" title="@lang('visitors.all_views')"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitors as $visitor)
                <tr>
                    <td class="py-1">
                        <a href="/master/visitors/{{ $visitor->id }}">
                            <span class="z-depth-1 new badge {{ $visitor->getStatusColor() }}">{{ $visitor->id }}</span>
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