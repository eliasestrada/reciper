@extends('layouts.auth')

@section('title', trans('visitors.visitors'))

@section('content')

<div class="page">
    <div class="center mb-3">
        <h1 class="header mb-4">
            <i class="fas fa-users red-text"></i> 
            @lang('visitors.visitors'): <span class="red-text">{{ number_format($visitors->count()) }}</span>
        </h1>
        <div class="divider"></div>
    </div>
    <div class="row container">
        <ul class="col s12 m6">
            <li><i class="main-text fas fa-eye tiny"></i> - @lang('visitors.recipes_viewed')</li>
        </ul>
        <ul class="col s12 m6">
            <li><i class="main-text fas fa-door-open tiny"></i> - @lang('visitors.first_visit')</li>
        </ul>
    </div>

    <table class="responsive-table striped highlight">
        <div class="divider"></div>
        <thead>
            <tr>
                <th class="py-1 main-text">#</th>
                <th class="py-1"><i class="fas fa-door-open main-text" title="@lang('visitors.first_visit')"></i></th>
                <th class="py-1"><i class="fas fa-eye main-text" title="@lang('visitors.recipes_viewed')"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visitors as $visitor)
                <tr>
                    <td class="py-1">
                        <a href="/master/visitors/{{ $visitor->id }}">
                            <span class="z-depth-1 new badge">{{ $visitor->id }}</span>
                        </a>
                    </td>
                    <td class="py-1">{{ time_ago($visitor->created_at) }}</td>
                    <td class="py-1">{{ $visitor->views->count() }}</td>
                </tr>
            @endforeach
            {{ $visitors->links() }}
        </tbody>
    </table>
</div>

@endsection