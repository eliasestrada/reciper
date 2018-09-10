@extends('layouts.app')

@section('title', trans('includes.notifications'))

@section('content')

<div class="page">
    <div class="center">
        <h1 class="headline">
            @lang('includes.notifications') 
            {{ $notifications->count() > 0 ? ": $notifications" : '' }}
        </h1>
    </div>
    
    <div class="row py-5">
        @forelse ($notifications as $notif)
            <div class="col s12 m6 l4">
                <div class="card-panel px-3">
                    <span>
                        <h6>
                            <i class="material-icons left main-text">notifications_none</i>
                            {{ trans($notif->title) }}
                        </h6>
                        <p>{{ $notif->message }}</p>
                        <hr />
                        <p>{{ $notif->data }}</p>
                        <span class="grey-text right">{{ time_ago($notif->created_at) }}</span>

                        @if ($notif->for_admins === 0)
                            <form action="{{ action('NotificationController@destroy', ['notification' => $notif->id]) }}" method="post" onsubmit='return confirm("@lang('notifications.sure_to_delete')")'>

                                @csrf
                                @method('delete')

                                <button class="btn" title="@lang('form.deleting')">
                                    @lang('form.deleting')
                                </button>
                            </form>
                        @endif
                    </span>
                </div>
            </div>
        @empty
            @component('comps.empty')
                @slot('text')
                    @lang('users.u_dont_have_notif')
                @endslot
            @endcomponent
        @endforelse
    </div>
        
    {{ $notifications->links() }}
</div>

@endsection