@extends('layouts.auth')

@section('title', trans('notifications.notifications'))

@section('content')

<div class="page">
    <div class="center pb-4">
        <h1 class="header">
            <i class="fas fa-bell red-text"></i> @lang('notifications.notifications') 
        </h1>
    </div>

    <div class="row">
        @forelse ($notifications as $notif)
            <a href="{{ ($notif['data']['link'] ?? '#') }}" class="col s12 m6 l4">
                <div class="card break-word">
                    <div class="card-panel px-3">
                        <span>
                            <h6 class="card-title">
                                <i class="fas fa-bell red-text fa-15x left"></i> {{ $notif['data']['title'] }}
                            </h6>
                            <p class="card-title">{!! $notif['data']['message'] !!}</p>
                            <span class="grey-text right">{{ time_ago($notif['created_at']) }}</span>
                        </span>
                    </div>
                </div>
            </a>
        @empty
            @component('comps.empty')
                @slot('text')
                    @lang('messages.no_messages')
                @endslot
            @endcomponent
        @endforelse
    </div>
</div>

@endsection